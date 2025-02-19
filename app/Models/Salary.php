<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
    protected $table = 'salary';
   
    protected $fillable = [
		     'employee_id','basic_salary',   
	];

  public function payslips()
  {
      return $this->belongsTo(Payslip::class);
  }
  public function employee()
  {
      return $this->belongsTo(Employee::class);
  }

  public function user()
  {
      return $this->belongsTo(User::class, 'employee_id','id');
  }
}
