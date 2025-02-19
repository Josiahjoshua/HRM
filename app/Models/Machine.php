<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
  
    public $timestamps = false;
    protected $table = 'machine';
      use HasFactory;

    protected $fillable = [
		'id','machine_name'    
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
