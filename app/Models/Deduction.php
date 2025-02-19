<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    use HasFactory;
    protected $table = 'deduction';
   
    protected $fillable = [
		     'name','description'
	];

  public function Payroll()
  {
      return $this->belongsTo('Payroll');
  }
  public function employeededuction()
  {
      return $this->hasMany(EmployeeDeduction::class);
  }
  
}