<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use App\Models\User;
use App\Models\Loan;
use App\Models\Payslip;
use Barryvdh\DomPDF\PDF;
use App\Models\Deduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Import the Carbon library
use Termwind\Components\Dd;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MonthlySalaryExport;
use Spatie\Pdf\Structure;
use Dompdf\Options;

class PayrolController extends Controller
{
  public function index()
  {
      // Get the earliest month from the start_date
      $earliestMonth = DB::table('salary')
          ->min(DB::raw('DATE_FORMAT(start_date, "%Y-%m")'));
  
      // Get the current month
      $currentMonth = now()->format('Y-m');
  
      $months = [];
      $current = $earliestMonth;
  
      while ($current <= $currentMonth) {
          $months[] = $current;
          $current = date('Y-m', strtotime("$current +1 month"));
      }
  
      $payroll = [];
  
      // Get all employees
      $employees = DB::table('users')->get();
  
      foreach ($months as $month) {
          $formattedMonth = date('Y-m', strtotime($month)); // Format the month separately
  
          $monthlyTotalSalaries = 0;
          $monthlyTotalDeductions = 0;
          $monthlyTotalBenefits = 0;
          $monthlyWorkOvertime = 0;
         
  
          foreach ($employees as $employee) {
              // Get the latest salary data for the employee for the current month
              $latestSalaryData = DB::table('salary')
                  ->where('employee_id', $employee->id)
                  ->whereRaw('DATE_FORMAT(start_date, "%Y-%m") <= ?', [$month])
                  ->whereRaw('DATE_FORMAT(end_date, "%Y-%m") >= ?', [$month])
                  ->orderBy('start_date', 'desc')
                  ->first();
  
              if ($latestSalaryData) {
                  $monthlyTotalSalaries += $latestSalaryData->basic_salary;
              }


              $latestDeductionsData = DB::table('employee_deduction')
              ->select('deduction_id', DB::raw('MAX(effective_date) as latest_effective_date'))
              ->where('employee_id', $employee->id)
              ->whereRaw('DATE_FORMAT(effective_date, "%Y-%m") <= ?', [$month])
              ->whereRaw('DATE_FORMAT(end_date, "%Y-%m") >= ?', [$month])
              ->groupBy('deduction_id')
              ->get();

              $deductionsTotal = 0;

              foreach ($latestDeductionsData as $deduction) {
                $deductionsTotal += DB::table('employee_deduction')
                    ->where('employee_id', $employee->id)
                    ->where('deduction_id', $deduction->deduction_id)
                    ->where('effective_date', '=', $deduction->latest_effective_date)
                    ->orderBy('effective_date', 'desc')
                    ->sum('amount');
            }

            if ($latestDeductionsData) {
              $monthlyTotalDeductions += $deductionsTotal;
          }

          $latestBenefitsData = DB::table('employee_benefit')
          ->select('benefit_id', DB::raw('MAX(effective_date) as latest_effective_date'))
          ->where('employee_id', $employee->id)
          ->whereRaw('DATE_FORMAT(effective_date, "%Y-%m") <= ?', [$month])
          ->whereRaw('DATE_FORMAT(end_date, "%Y-%m") >= ?', [$month])
          ->groupBy('benefit_id')
          ->get();

          $benefitsTotal = 0;

          foreach ($latestBenefitsData as $benefit) {
            $benefitsTotal += DB::table('employee_benefit')
                ->where('employee_id', $employee->id)
                ->where('benefit_id', $benefit->benefit_id)
                ->where('effective_date', '=', $benefit->latest_effective_date)
                ->orderBy('effective_date', 'desc')
                ->sum('amount');
        }

        if ($latestBenefitsData) {
          $monthlyTotalBenefits += $benefitsTotal;
      }
  
        

              $workOvertimeData = DB::table('workovertime')
              ->where('employee_id', $employee->id)
              ->whereRaw('DATE_FORMAT(workovertime.date, "%Y-%m") = ?', [$month])
              ->select(DB::raw('SUM(amount_per_hour * total_hours) as total_amount'))
              ->first();
          
          if ($workOvertimeData) {
              $monthlyWorkOvertime += $workOvertimeData->total_amount;
          }
          
          
          }
          
    
  
          $payrollDataRow = [
              'month' => $formattedMonth,
              'total_salaries' => $monthlyTotalSalaries,
              'total_deductions' => $monthlyTotalDeductions,
              'total_benefits' => $monthlyTotalBenefits,
              'total_workovertimes' => $monthlyWorkOvertime ,
          ];
  
          $payroll[] = (object) $payrollDataRow;
      }
  
      return view('payrol.salary.index', compact('payroll'));
  }
  
  

  public function myPayroll()
  {
      // Get the currently logged-in user
      $user = Auth::user();
  
      // Get the earliest month from the start_date of the logged-in user
      $earliestMonth = DB::table('salary')
          ->where('employee_id', $user->id)
          ->min(DB::raw('DATE_FORMAT(start_date, "%Y-%m")'));
  
      // Get the current month
      $currentMonth = now()->format('Y-m');
  
      $months = [];
      $current = $earliestMonth;
  
      while ($current <= $currentMonth) {
          $months[] = $current;
          $current = date('Y-m', strtotime("$current +1 month"));
      }
  
      $payrollData = [];
  
      foreach ($months as $month) {
          $formattedMonth = date('Y-m', strtotime($month)); // Format the month separately
          $payrollDataRow = [
              'month' => $formattedMonth,
              'salary' => 0, // Initialize the salary to 0
              'benefits' => 0,
              'workovertimes' => 0,
              'deductions' => 0,
              'id' => 0,
          ];
  
          // Get the latest salary data for the current month
          $latestSalaryData = DB::table('salary')
              ->where('employee_id', $user->id)
              ->whereRaw('DATE_FORMAT(start_date, "%Y-%m") <= ?', [$month])
              ->whereRaw('DATE_FORMAT(end_date, "%Y-%m") >= ?', [$month])
              ->orderBy('start_date', 'desc')
              ->first();
  
          if ($latestSalaryData) {
              $payrollDataRow['salary'] = $latestSalaryData->basic_salary;
              $payrollDataRow['id'] = $latestSalaryData->id;
          }
  
          // Get the latest deductions data for the current month and sum them up
          $latestDeductionsData = DB::table('employee_deduction')
              ->where('employee_id', $user->id)
              ->whereRaw('DATE_FORMAT(effective_date, "%Y-%m") <= ?', [$month])
              ->whereRaw('DATE_FORMAT(end_date, "%Y-%m") >= ?', [$month])
              ->orderBy('effective_date', 'desc')
              ->get();
  
          if ($latestDeductionsData) {
              $deductionsTotal = 0;
              foreach ($latestDeductionsData as $deduction) {
                  $deductionsTotal += $deduction->amount;
              }
              $payrollDataRow['deductions'] = $deductionsTotal;
          }
  
          // Get the latest benefits data for the current month and sum them up
          $latestBenefitsData = DB::table('employee_benefit')
              ->where('employee_id', $user->id)
              ->whereRaw('DATE_FORMAT(effective_date, "%Y-%m") <= ?', [$month])
              ->whereRaw('DATE_FORMAT(end_date, "%Y-%m") >= ?', [$month])
              ->orderBy('effective_date', 'desc')
              ->get();
  
          if ($latestBenefitsData) {
              $benefitsTotal = 0;
              foreach ($latestBenefitsData as $benefit) {
                  $benefitsTotal += $benefit->amount;
              }
              $payrollDataRow['benefits'] = $benefitsTotal;
          }
  
          // Add work overtime for the current month
          $workOvertimeData = DB::table('workovertime')
              ->where('employee_id', $user->id)
              ->whereRaw('DATE_FORMAT(date, "%Y-%m") = ?', [$month])
              ->where('status','=', 1)
              ->sum(DB::raw('amount_per_hour * total_hours'));
  
          $payrollDataRow['workovertimes'] = $workOvertimeData;
  
          $payrollData[] = (object) $payrollDataRow;
      }
  
      return view('payrol.salary.myPayrol', compact('payrollData'));
  }
  


  public function monthlyEmployeePayroll($month)
  {
      // Retrieve payroll data for all employees for the given month
      $payrollData = DB::table('users')
      ->select(
          'users.name as employee_name',
          'salary.basic_salary as salary',
          'salary.id'
      )
      ->leftJoin('salary', function ($join) use ($month) {
          $join->on('users.id', '=', 'salary.employee_id')
              ->whereRaw('DATE_FORMAT(salary.start_date, "%Y-%m") <= ?', [$month])
              ->whereRaw('DATE_FORMAT(salary.end_date, "%Y-%m") >= ?', [$month])
              ->whereRaw('salary.id = (SELECT MAX(id) FROM salary WHERE employee_id = users.id AND DATE_FORMAT(start_date, "%Y-%m") <= ?)', [$month]);
      })
      ->whereNotNull('salary.id') // This line excludes employees with no matching salary records for the given month
      ->groupBy('users.name', 'salary.basic_salary', 'salary.id')
      ->get();
  
      // Iterate through each employee's payroll data and add deductions, benefits, and work overtime for the given month
      foreach ($payrollData as $key => $employeeData) {
          $employeeId = DB::table('users')->where('name', $employeeData->employee_name)->value('id');
  
              $deductions = DB::table('employee_deduction')
              ->select('deduction_id', DB::raw('MAX(effective_date) as latest_effective_date'))
              ->where('employee_id', $employeeId)
              ->whereRaw('DATE_FORMAT(effective_date, "%Y-%m") <= ?', [$month])
              ->whereRaw('DATE_FORMAT(end_date, "%Y-%m") >= ?', [$month])
              ->groupBy('deduction_id')
              ->get();

              $deductionsTotal = 0;

              foreach ($deductions as $deduction) {
                $deductionsTotal += DB::table('employee_deduction')
                    ->where('employee_id', $employeeId)
                    ->where('deduction_id', $deduction->deduction_id)
                    ->where('effective_date', '=', $deduction->latest_effective_date)
                    ->sum('amount');
            }
  
          // Calculate and add benefits for the current month considering effective dates
          $benefits = DB::table('employee_benefit')
          ->select('benefit_id', DB::raw('MAX(effective_date) as latest_effective_date'))
          ->where('employee_id', $employeeId)
          ->whereRaw('DATE_FORMAT(effective_date, "%Y-%m") <= ?', [$month])
          ->whereRaw('DATE_FORMAT(end_date, "%Y-%m") >= ?', [$month])
          ->groupBy('benefit_id')
          ->get();


          $benefitsTotal = 0;

          foreach ($benefits as $benefit) {
            $benefitsTotal += DB::table('employee_benefit')
                ->where('employee_id', $employeeId)
                ->where('benefit_id', $benefit->benefit_id)
                ->where('effective_date', '=', $benefit->latest_effective_date)
                ->sum('amount');
        }
  
          // Calculate and add work overtime for the current month
          $workOvertime = DB::table('workovertime')
              ->where('employee_id', $employeeId)
              ->whereRaw('DATE_FORMAT(workovertime.date, "%Y-%m") = ?', [$month])
              ->where('status','=', 1)
              ->sum(DB::raw('amount_per_hour * total_hours'));
  
          // Add calculated values to the employee's data
          $payrollData[$key]->deductions = $deductionsTotal;
          $payrollData[$key]->benefits = $benefitsTotal;
          $payrollData[$key]->workovertime = $workOvertime;
  
          // Check if there are updated salary records for the current month and update the salary accordingly
          $updatedSalary = DB::table('salary')
              ->where('employee_id', $employeeId)
              ->whereRaw('DATE_FORMAT(start_date, "%Y-%m") <= ?', [$month])
              ->whereRaw('DATE_FORMAT(end_date, "%Y-%m") >= ?', [$month])
              ->orderBy('start_date', 'desc')
              ->value('basic_salary');
  
          if ($updatedSalary) {
              $payrollData[$key]->salary = $updatedSalary;
          }
      }
  
      return view('payrol.salary.monthlyEmployeePayrol', compact('payrollData', 'month'));
  }


  public function create()
  {

    $salary = Employee::with('payrol', 'department')->get();
    return view('payrol.salary.show', compact('salary'));
  }

  public function show($id)
  {

    $payroll = Payroll::where('id', $id)->firstOrFail();
    $payslip = Payslip::with('user')->where('payroll_id', $id)->get();
    return view('payrol.salary.create', compact('payroll', 'payslip'));
  }

 

  public function view_payslip($id)
  {
    $payslip = Payslip::findOrFail($id);
    $userId = Auth::user()->id;
    $employeeId = Employee::where('name', $userId->name)->first();
    return view('payrol.payslip.index', compact('payslip','employeeId'));
  }

 
  
public function generate_payslip($month)
{
    $userId = Auth::user()->id;
    $user = Auth::user();
    $employee = Employee::where('email', $user->email)->first();
    $customHeading ="Salary Slip Of " . date('M Y', strtotime($month));
    
    
    $manager = User::whereHas('roles', function ($query) {
    $query->where('name', 'manager');
})->first();

    // Retrieve basic salary for the given month
    $basicSalaryData = DB::table('salary')
        ->select('basic_salary')
        ->where('employee_id', $userId)
        ->whereRaw('DATE_FORMAT(start_date, "%Y-%m") <= ?', [$month])
        ->whereRaw('DATE_FORMAT(end_date, "%Y-%m") >= ?', [$month])
        ->first();

    // Retrieve benefits for the given month
    $benefitsData = DB::table('employee_benefit')
        ->select('benefit.name', 'amount')
        ->where('employee_id', $userId)
        ->join('benefit', 'benefit.id', '=', 'employee_benefit.benefit_id')
        ->whereRaw('DATE_FORMAT(effective_date, "%Y-%m") <= ?', [$month])
        ->whereRaw('DATE_FORMAT(end_date, "%Y-%m") >= ?', [$month])
        ->groupBy('name', 'amount')
        ->get();

    // Format benefits data as a string (benefit_name - amount)
    $benefits = [];
    foreach ($benefitsData as $benefit) {
        $benefits[] = "{$benefit->name} - {$benefit->amount}";
    }

    // Retrieve deductions for the given month
    $deductionsData = DB::table('employee_deduction')
        ->select('deduction.name', 'amount')
        ->where('employee_id', $userId)
        ->join('deduction', 'deduction.id', '=', 'employee_deduction.deduction_id')
        ->whereRaw('DATE_FORMAT(effective_date, "%Y-%m") <= ?', [$month])
        ->whereRaw('DATE_FORMAT(end_date, "%Y-%m") >= ?', [$month])
        ->groupBy('name', 'amount')
        ->get();

    // Format deductions data as a string (deduction_name - amount)
    $deductions = [];
    foreach ($deductionsData as $deduction) {
        $deductions[] = "{$deduction->name} - {$deduction->amount}";
    }

    // Retrieve work overtime for the given month
    $workOvertime = DB::table('workovertime')
        ->where('employee_id', $userId)
        ->whereRaw('DATE_FORMAT(date, "%Y-%m") = ?', [$month])
        ->where('status', '=', 1)
        ->sum(DB::raw('amount_per_hour * total_hours'));

    // Calculate the total deductions and benefits
    $totalDeductions = $deductionsData->sum('amount');
    $totalBenefits = $benefitsData->sum('amount');

    // Calculate the net salary
    $basicSalary = $basicSalaryData ? $basicSalaryData->basic_salary : 0;
    $netSalary = $basicSalary + $totalBenefits + $workOvertime - $totalDeductions;
    
    
    
      $imagePath = public_path('/dist/img/pejunlogo2.png');

        $fontPath = storage_path('fonts/Roboto-Regular.ttf');


        // Create an instance of the PDF class with the required arguments
        $pdf = new PDF(
            app('dompdf'), // You may need to adjust this if 'dompdf' is not the correct service name
            app('config'), // Create an instance of the config repository
            app('files'), // Create an instance of the filesystem
            app('view') // The name of your view
        );

        $pdf->loadView('payrol.payslip.slip', compact('manager','basicSalary','benefitsData','imagePath','deductionsData', 'workOvertime', 'totalDeductions', 'totalBenefits', 'netSalary','employee','customHeading'));
        $pdf->getDomPDF()->getOptions()->setFontDir($fontPath);
        $pdf->getDomPDF()->getOptions()->setDefaultFont('Roboto-Regular');
        $pdf->setPaper('A4', 'portrait');
        $pdf->setWarnings(false);

        $options = new Options();
$options->set('isPhpEnabled', true); // Enable PHP processing in your HTML
$options->set('isHtml5ParserEnabled', true); // Enable HTML5 parsing
$options->set('isRemoteEnabled', true); // Allow loading external stylesheets


        return $pdf->stream('payslip.pdf');
    
    
    
    
    
    

    // Create a separate collection for each type of data
    // $basicSalaryCollection = $basicSalary;
    // $benefitsCollection = collect($benefitsData);
    // $deductionsCollection = collect($deductionsData);

    // Append benefits, deductions, and work overtime to their respective collections
    // $benefitsCollection->push((object)['name' => 'Total Benefits', 'amount' => $totalBenefits]);
    // $deductionsCollection->push((object)['name' => 'Total Deductions', 'amount' => $totalDeductions]);

 

    // return Excel::download(new MonthlySalaryExport($basicSalaryCollection, $benefitsCollection, $deductionsCollection, $workOvertime, $netSalary, $month, $customHeading), 'salary_report.xlsx');
}

  


  
  
}
