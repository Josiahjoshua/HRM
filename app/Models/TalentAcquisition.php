<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalentAcquisition extends Model {
    use HasFactory;

    protected $fillable = ['job_title', 'description', 'application_deadline', 'status'];
}
