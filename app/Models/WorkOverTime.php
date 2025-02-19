<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOverTime extends Model
{
    use HasFactory;
    protected $table = 'workovertime';
   
    protected $fillable = [
		     'employee_id','amount',   
	];

  public function payroll()
  {
      return $this->belongsTo(Payroll::class);
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
