<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;
    protected $table = 'payroll';
    protected $fillable = [ 'month', 'status' ];

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee', 'employee_id', 'id');
    }
    public function salary()
    {
        return $this->belongsTo('App\Models\Salary', 'salary_id', 'id');
    }

    public function payslips()
    {
        return $this->hasMany(Payslip::class, 'payroll_id');
    }
    
public function workovertime()
{
    return $this->hasMany(WorkOverTime::class);
}
}
