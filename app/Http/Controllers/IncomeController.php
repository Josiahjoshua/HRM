<?php

namespace App\Http\Controllers;

use App\Models\WorkOverTime;
use App\Models\EmployeeBenefit;
use App\Models\EmployeeDeduction;
use App\Models\User;
use App\Models\Income;
use App\Models\Expenditure;
use App\Models\FundRequest;
use App\Models\Perdeim;
use App\Models\Salary;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\PDF;
use Spatie\Pdf\Structure;
use Dompdf\Options;
use Termwind\Components\Dd;

class IncomeController extends Controller
{
  public function index()
  {

    $user = User::all();

    $monthlyIncome = DB::table('income')
      ->select(DB::raw('DATE_FORMAT(date, "%Y-%m") as month'), DB::raw('SUM(amount) as total_amount'))
      ->groupBy('month')
      ->orderBy('month', 'desc')
      ->get();

    $dailyIncome = Income::all();
    return view('income.index', compact('monthlyIncome', 'user', 'dailyIncome'));
  }



  public function store(Request $request)
  {
    $request->validate([

      'amount' => 'required',
      'from' => 'required',
      'desc' => 'required',
      'date' => 'required',
      'category_id' => 'required'
    ]);

    $income = new Income();
    $income->date = request('date');
    $income->from = request('from');
    $income->amount = request('amount');
    $income->desc = request('desc');
    $income->category_id = request('category_id');
    $income->save();
    Alert::success('Success!', 'Successfully added');
    return back();
  }

  public function destroy($id)
  {

    $income = Income::findOrFail($id);
    $income->delete();
    Alert::success('Success!', 'Successfully deleted');
    return back();
  }

  public function edit($id)
  {

    $income = Income::findOrFail($id);

    return view('income.edit', compact('income'));
  }

  public function update(Request $request, $id)
  {
    $income = Income::find($id);

    // Validate the request data
    $request->validate([

      'amount' => 'required',
      'from' => 'required',
      'desc' => 'required',
      'date' => 'required'
    ]);


    $income->date = request('date');
    $income->from = request('from');
    $income->amount = request('amount');
    $income->desc = request('desc');

    // Save the updated timesheet
    $income->save();
    Alert::success('Success!', 'Successfully updated');
  }

  public function profitNLoss()
  {

    $incomes = Income::all();
    $totalIncome = $incomes->sum('amount');

    $expenditures = Expenditure::all();
    $totalExpenditure = $expenditures->sum('amount');

    $profitLoss = $totalIncome - $totalExpenditure;



    return view('income.profitNloss', compact('incomes', 'expenditures', 'totalIncome',  'totalExpenditure', 'profitLoss'));
  }


  public function profitLoss(Request $request)
  {


    $startDate = request('start_date');
    $endDate = request('end_date');



    // Fetch incomes within the date range
    $incomes = Income::whereBetween('date', [$startDate, $endDate])->get();
    $totalIncome = $incomes->sum('amount');

    // Fetch expenditures within the date range
    $expenditures = Expenditure::whereBetween('date', [$startDate, $endDate])->get();
    $totalExpenditures = $expenditures->sum('amount');

    $perdeims = Perdeim::whereBetween('date', [$startDate, $endDate])
      ->where('statusManager', 1)
      ->where('statusDr', 1)
      ->get();
    $totalPerdeim = $perdeims->sum('amount');

    //  dd($perdeims);

    $fundRequests = FundRequest::whereBetween('date', [$startDate, $endDate])
      ->where('statusManager', 1)
      ->where('statusDr', 1)
      ->get();
    $totalfundRequest = $fundRequests->sum('amount');


    $basicSalaries = Salary::where(function ($query) use ($startDate, $endDate) {
      $query->where('start_date', '<=', $endDate)
            ->where(function ($query) use ($startDate) {
                $query->where('end_date', '>=', $startDate)
                      ->orWhereNull('end_date');
            });
  })
  ->get(); // Retrieve the salaries matching the criteria

$totalSalary = 0;

foreach ($basicSalaries as $salary) {
  $contractStartDate = strtotime($salary->start_date);
  $contractEndDate = strtotime($salary->end_date ?? $endDate); // If end date is null, consider $endDate
  
  // Adjust the contract start date to be at least the $startDate
  $effectiveStartDate = max($contractStartDate, strtotime($startDate));

  // Adjust the contract end date to be at most the $endDate
  $effectiveEndDate = min($contractEndDate, strtotime($endDate));

  // Calculate the number of months where the 28th falls within the range
  $monthsCovered = 0;
  $currentDate = $effectiveStartDate;

  while ($currentDate <= $effectiveEndDate) {
      // Check if the 28th of the current month falls within the range
      $month28th = strtotime(date('Y-m-28', $currentDate));
      if ($month28th >= $effectiveStartDate && $month28th <= $effectiveEndDate) {
          $monthsCovered++;
      }

      // Move to the next month
      $currentDate = strtotime('+1 month', $currentDate);
  }

  // Calculate the salary for the covered months
  $salaryForMonths = $monthsCovered * $salary->basic_salary;

  $totalSalary += $salaryForMonths;
}



$totalBenefits = 0;
$totalDeductions = 0;

// Loop through each month within the specified period
$currentDate = strtotime($startDate);
$endDateTimestamp = strtotime($endDate);

while ($currentDate <= $endDateTimestamp) {
    // Check if the 28th of the current month falls within the range
    $month28th = strtotime(date('Y-m-28', $currentDate));

    // Check if the 28th falls within the range of the selected dates
    if ($month28th >= strtotime($startDate) && $month28th <= $endDateTimestamp) {
        // Sum the benefits for the current month
        $benefitsForMonth = EmployeeBenefit::where(function ($query) use ($month28th) {
                $query->where('effective_date', '<=', date('Y-m-d', $month28th))
                      ->where(function ($query) use ($month28th) {
                          $query->where('end_date', '>=', date('Y-m-d', $month28th))
                                ->orWhereNull('end_date');
                      });
            })
            ->sum('amount');



        // Sum the deductions for the current month
        $deductionsForMonth = EmployeeDeduction::where(function ($query) use ($month28th) {
                $query->where('effective_date', '<=', date('Y-m-d', $month28th))
                      ->where(function ($query) use ($month28th) {
                          $query->where('end_date', '>=', date('Y-m-d', $month28th))
                                ->orWhereNull('end_date');
                      });
            })
            ->sum('amount');

        // Add benefits and deductions for the current month
        $totalBenefits += $benefitsForMonth;
        $totalDeductions += $deductionsForMonth;
    }

   

    // Move to the next month
    $currentDate = strtotime('+1 month', $currentDate);
}


    $totalOvertimePay = WorkOvertime::whereBetween('date', [$startDate, $endDate])
      ->where('status', 1)
      ->sum(DB::raw('amount_per_hour * total_hours'));


    $netSalary = $totalSalary + $totalBenefits + $totalOvertimePay - $totalDeductions;

    $totalExpenditure = $totalExpenditures +  $netSalary + $totalfundRequest +  $totalPerdeim;

    $profitLoss = $totalIncome - $totalExpenditure;

    return view('income.profitloss', compact('incomes', 'expenditures', 'totalIncome', 'totalExpenditure', 'startDate', 'endDate', 'profitLoss', 'fundRequests', 'perdeims', 'netSalary'));
  }


  public function profitLossReport(Request $request)
  {


    $startDate = request('start_date');
    $endDate = request('end_date');


    // Fetch incomes within the date range
    $incomes = Income::whereBetween('date', [$startDate, $endDate])->get();
    $totalIncome = $incomes->sum('amount');

    // Fetch expenditures within the date range
    $expenditures = Expenditure::whereBetween('date', [$startDate, $endDate])->get();
    $totalExpenditures = $expenditures->sum('amount');

    $perdeims = Perdeim::whereBetween('date', [$startDate, $endDate])
      ->where('statusManager', 1)
      ->where('statusDr', 1)
      ->get();
    $totalPerdeim = $perdeims->sum('amount');

    //  dd($perdeims);

    $fundRequests = FundRequest::whereBetween('date', [$startDate, $endDate])
      ->where('statusManager', 1)
      ->where('statusDr', 1)
      ->get();
    $totalfundRequest = $fundRequests->sum('amount');


    $basicSalaries = Salary::where(function ($query) use ($startDate, $endDate) {
      $query->where('start_date', '<=', $endDate)
            ->where(function ($query) use ($startDate) {
                $query->where('end_date', '>=', $startDate)
                      ->orWhereNull('end_date');
            });
  })
  ->get(); // Retrieve the salaries matching the criteria

$totalSalary = 0;

foreach ($basicSalaries as $salary) {
  $contractStartDate = strtotime($salary->start_date);
  $contractEndDate = strtotime($salary->end_date ?? $endDate); // If end date is null, consider $endDate
  
  // Adjust the contract start date to be at least the $startDate
  $effectiveStartDate = max($contractStartDate, strtotime($startDate));

  // Adjust the contract end date to be at most the $endDate
  $effectiveEndDate = min($contractEndDate, strtotime($endDate));

  // Calculate the number of months where the 28th falls within the range
  $monthsCovered = 0;
  $currentDate = $effectiveStartDate;

  while ($currentDate <= $effectiveEndDate) {
      // Check if the 28th of the current month falls within the range
      $month28th = strtotime(date('Y-m-28', $currentDate));
      if ($month28th >= $effectiveStartDate && $month28th <= $effectiveEndDate) {
          $monthsCovered++;
      }

      // Move to the next month
      $currentDate = strtotime('+1 month', $currentDate);
  }

  // Calculate the salary for the covered months
  $salaryForMonths = $monthsCovered * $salary->basic_salary;

  $totalSalary += $salaryForMonths;
}



$totalBenefits = 0;
$totalDeductions = 0;

// Loop through each month within the specified period
$currentDate = strtotime($startDate);
$endDateTimestamp = strtotime($endDate);

while ($currentDate <= $endDateTimestamp) {
    // Check if the 28th of the current month falls within the range
    $month28th = strtotime(date('Y-m-28', $currentDate));

    // Check if the 28th falls within the range of the selected dates
    if ($month28th >= strtotime($startDate) && $month28th <= $endDateTimestamp) {
        // Sum the benefits for the current month
        $benefitsForMonth = EmployeeBenefit::where(function ($query) use ($month28th) {
                $query->where('effective_date', '<=', date('Y-m-d', $month28th))
                      ->where(function ($query) use ($month28th) {
                          $query->where('end_date', '>=', date('Y-m-d', $month28th))
                                ->orWhereNull('end_date');
                      });
            })
            ->sum('amount');



        // Sum the deductions for the current month
        $deductionsForMonth = EmployeeDeduction::where(function ($query) use ($month28th) {
                $query->where('effective_date', '<=', date('Y-m-d', $month28th))
                      ->where(function ($query) use ($month28th) {
                          $query->where('end_date', '>=', date('Y-m-d', $month28th))
                                ->orWhereNull('end_date');
                      });
            })
            ->sum('amount');

        // Add benefits and deductions for the current month
        $totalBenefits += $benefitsForMonth;
        $totalDeductions += $deductionsForMonth;
    }

   

    // Move to the next month
    $currentDate = strtotime('+1 month', $currentDate);
}


    $totalOvertimePay = WorkOvertime::whereBetween('date', [$startDate, $endDate])
      ->where('status', 1)
      ->sum(DB::raw('amount_per_hour * total_hours'));


    $netSalary = $totalSalary + $totalBenefits + $totalOvertimePay - $totalDeductions;

    $totalExpenditure = $totalExpenditures +  $netSalary + $totalfundRequest +  $totalPerdeim;

    $profitLoss = $totalIncome - $totalExpenditure;




    $imagePath = public_path('/dist/img/pejunlogo2.png');

    $fontPath = storage_path('fonts/Roboto-Regular.ttf');


    // Create an instance of the PDF class with the required arguments
    $pdf = new PDF(
      app('dompdf'), // You may need to adjust this if 'dompdf' is not the correct service name
      app('config'), // Create an instance of the config repository
      app('files'), // Create an instance of the filesystem
      app('view') // The name of your view
    );

    $pdf->loadView('income.profitLossReport', compact('incomes', 'expenditures', 'totalIncome', 'imagePath', 'totalExpenditure', 'startDate', 'endDate', 'profitLoss', 'fundRequests', 'perdeims', 'netSalary'));
    $pdf->getDomPDF()->getOptions()->setFontDir($fontPath);
    $pdf->getDomPDF()->getOptions()->setDefaultFont('Roboto-Regular');
    $pdf->setPaper('A4', 'portrait');
    $pdf->setWarnings(false);

    $options = new Options();
    $options->set('isPhpEnabled', true); // Enable PHP processing in your HTML
    $options->set('isHtml5ParserEnabled', true); // Enable HTML5 parsing
    $options->set('isRemoteEnabled', true); // Allow loading external stylesheets


    return $pdf->stream('profit_loss_report.pdf');
  }
}
