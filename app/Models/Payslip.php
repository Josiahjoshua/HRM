<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    use HasFactory;
    protected $table = 'payslip';
    protected $fillable = [ 'employee_id', 'payroll_id', 'salary', 'allowance_amount','deduction_amount','net_pay', 
];

public function employee()
{
    return $this->belongsTo('App\Models\Employee', 'employee_id', 'id');
}

public function user()
{
    return $this->belongsTo(User::class, 'employee_id','id');
}
public function payroll()
{
    return $this->belongsTo('App\Models\Payroll', 'payroll_id', 'id');
}
public function salary()
{
    return $this->hasOne('App\Models\Salary', 'payslip_id');
}

public function benefits()
{
    return $this->hasMany(Benefit_Payslip::class,'payslip_id');
}
public function deductions()
{
  
    return $this->hasMany(Deduction_Payslip::class,'payslip_id');
}




}
