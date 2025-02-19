<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    use HasFactory;
    protected $table = 'benefit';
   
    protected $fillable = [
		'name','description',   
	];

  public function Payroll()
  {
      return $this->belongsTo('Payroll');
  }
  public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function employeebenefit()
    {
        return $this->hasMany(EmployeeBenefit::class);
    }
}