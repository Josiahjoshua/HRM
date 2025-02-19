<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Earn_leave extends Model 
{
    use HasFactory;
    protected $table = 'earn_leave';
    public $timestamps = false;
    protected $fillable = [
		'id','employee_id','start_date','end_date', 'total_earndays',   
	];

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee', 'employee_id', 'id');
    }

}