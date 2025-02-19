<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Leave_application extends Model 
{
    use HasFactory, Notifiable;
    protected $table = 'leave_application';
    // public $timestamps = false;
    protected $fillable = [
		'id','leave_id','employee_id','start_date','end_date','reason','status',  'total_day' , 'day_remain',
	];

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee', 'employee_id', 'id');
    }

    
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'employee_id', 'id');
    }

    public function leave_type()
    {
        return $this->belongsTo('App\Models\Leave_type', 'leave_id', 'id');
    }
public function approver()
    {
        return $this->belongsTo(Employee::class, 'approver_id');
    }
}
