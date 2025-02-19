<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDeduction extends Model
{
    use HasFactory;
    protected $table = 'employee_deduction';
   
    protected $fillable = [
		     'employee_id','deduction_id','effective_date','amount','end_date'   
	];


    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id','id');
    }
    public function deduction()
    {
        return $this->belongsTo(Deduction::class, 'deduction_id', 'id');
    }
    public function payslip()
  {
      return $this->belongsTo('Payslip');
  }
}
