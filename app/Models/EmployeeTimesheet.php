<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTimesheet extends Model
{
  
    public $timestamps = false;
    protected $table = 'employeetimesheet';
      use HasFactory;

    protected $fillable = [
		'id','employee_id','start_hour','end_hour','date','overtime'    
	];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'employee_id', 'id');
    }
  public function logistic()
  {
      return $this->hasOne('Logistic');
  }
  
}
