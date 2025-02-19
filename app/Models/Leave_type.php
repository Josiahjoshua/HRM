<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Leave_type extends Model 
{
    use HasFactory;
    protected $table = 'leave_type';
    public $timestamps = false;
    protected $fillable = [
		'leavename','day_no',   
	];

  public function leave_application()
  {
      return $this->hasMany('Leave_application');
  }
}