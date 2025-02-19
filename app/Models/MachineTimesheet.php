<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineTimesheet extends Model
{
  
    public $timestamps = false;
    protected $table = 'machinetimesheet';
      use HasFactory;

    protected $fillable = [
		'id','activities','fuel','employee_id','start_hour','end_hour','date','machine_id'    
	];

    public function employee()
    {
        return $this->belongsTo('App\Models\User', 'employee_id', 'id');
    }
  public function logistic()
  {
      return $this->hasOne('Logistic');
  }
  
}
