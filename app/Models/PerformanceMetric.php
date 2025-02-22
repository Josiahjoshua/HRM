<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceMetric extends Model {
    use HasFactory;

    protected $fillable = ['employee_id', 'kpi', 'score', 'remarks'];

    public function employee() {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
