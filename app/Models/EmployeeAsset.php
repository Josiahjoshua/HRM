<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAsset extends Model
{
    use HasFactory;
    protected $fillable = [
        'assetlist_id',
        'employee_id',
        'serial_number',
        'status',
        'return_date'
    ];

    public function assetlist()
    {
        return $this->belongsTo(Assetlist::class, 'assetlist_id', 'id');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id','id');
    }
}
