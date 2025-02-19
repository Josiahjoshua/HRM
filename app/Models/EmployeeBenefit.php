<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeBenefit extends Model
{
    use HasFactory;
    protected $table = 'employee_benefit';
   
    protected $fillable = [
		     'employee_id','benefit_id','effective_date','amount','end_date'   
	];


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id','id');
    }
    public function benefit()
    {
        return $this->belongsTo(Benefit::class);
    }
    public function payslip()
  {
      return $this->belongsTo('Payslip');
  }
}
