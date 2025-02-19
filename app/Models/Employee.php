<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees';
    protected $fillable = ['name', 'email', 'password','em_address','department_id','designation_id','gender','em_phone'];


public function salary()
{
    return $this->hasOne(Salary::class);
}

public function department()
{
    return $this->belongsTo(Department::class, 'department_id', 'id');
}

public function designation()
{
    return $this->belongsTo(Designation::class, 'designation_id', 'id');
}

}