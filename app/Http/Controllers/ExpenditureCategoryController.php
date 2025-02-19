<?php

namespace App\Http\Controllers;

use App\Models\WorkOverTime;
use App\Models\Expenditure;
use App\Models\Perdeim;
use App\Models\ExpenditureCategory;
use App\Models\FundRequest;
use App\Models\EmployeeBenefit;
use App\Models\EmployeeDeduction;
use App\Models\Salary;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ExpenditureCategoryController extends Controller
{
  public function index()
  {
    $expenditure = ExpenditureCategory::all();
    return view('expenditure.category', compact('expenditure'));
  }

  public function show($id)
  {
      $expenditure = ExpenditureCategory::find($id);
  
      if ($expenditure->category_name == "Fund Request") {
          $monthlyExpenditure = FundRequest::where('statusManager', 1)
              ->where('statusDr', 1)
              ->select(
                  DB::raw('DATE_FORMAT(date, "%Y-%m") as month'),
                  DB::raw('SUM(amount) as total_amount')
              )
              ->groupBy('month')
              ->orderBy('month', 'desc')
              ->get();
          $dailyExpenditure = FundRequest::all();
      }  elseif ($expenditure->category_name == "Perdeim") {
          $monthlyExpenditure = Perdeim::where('statusManager', 1)
              ->where('statusDr', 1)
              ->select(
                  DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                  DB::raw('SUM(amount) as total_amount')
              )
              ->groupBy('month')
              ->orderBy('month', 'desc')
              ->get();
          $dailyExpenditure = Perdeim::all();
      }elseif ($expenditure->category_name == "Net Salary") {
        // Calculate net salary here
        $monthlyExpenditure = $this->calculateNetSalary();
        $dailyExpenditure = []; // No daily expenditure for Net Salary category
    } else {
          // Default behavior for other categories
          $monthlyExpenditure =  DB::table('expenditure')
              ->select(DB::raw('DATE_FORMAT(date, "%Y-%m") as month'), DB::raw('SUM(amount) as total_amount'))
              ->where('category_id', $id)
              ->groupBy('month')
              ->orderBy('month','desc')
              ->get();
          $dailyExpenditure = Expenditure::where('category_id', $id)->get();
      }
  
      return view('expenditure.index', compact('monthlyExpenditure', 'expenditure', 'dailyExpenditure'));
  }
  
  private function calculateNetSalary()
  {
      $earliestMonth = DB::table('salary')
          ->min(DB::raw('DATE_FORMAT(start_date, "%Y-%m")'));
  
      $currentMonth = now()->format('Y-m');
  
      $months = [];
      $current = $earliestMonth;
  
      while ($current <= $currentMonth) {
          $months[] = $current;
          $current = date('Y-m', strtotime("$current +1 month"));
      }
  
      $netSalaries = [];
  
      $employees = DB::table('users')->get();
  
      foreach ($months as $month) {
          $formattedMonth = date('Y-m', strtotime($month));
  
          $monthlyTotalSalaries = 0;
          $monthlyTotalDeductions = 0;
          $monthlyTotalBenefits = 0;
          $monthlyWorkOvertime = 0;
  
          foreach ($employees as $employee) {
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
  
          $netSalary = $monthlyTotalSalaries - $monthlyTotalDeductions + $monthlyTotalBenefits + $monthlyWorkOvertime;
  
          $netSalaries[] = (object) [
            'month' => $formattedMonth,
            'total_amount' => $netSalary,
        ];
      }
  
      return $netSalaries;
  }
  
  
  


  public function store(Request $request)
  {
    $request->validate([
      'category_name' => 'required',

    ]);

    $machine = new ExpenditureCategory();
    $machine->category_name = request('category_name');
    $machine->save();
    Alert::success('Success!', 'Successfully added');
    return back();
  }

  public function destroy($id)
  {

    $machine = ExpenditureCategory::findOrFail($id);
    $machine->delete();
    Alert::success('Success!', 'Successfully deleted');
    return back();
  }

  public function edit($id)
  {

    $expenditure = ExpenditureCategory::findOrFail($id);
    return view('expenditure.editCategory', compact('expenditure'));
  }

  public function update(Request $request, $id)
  {

    $request->validate([
      'category_name' => 'required',

    ]);

     $machine = ExpenditureCategory::find($id);
    $machine->category_name = request('category_name');
    $machine->save();

    Alert::success('Success!', 'Successfully updated');
    return redirect()->route('expenditureCategory.index');
  }

  


}
