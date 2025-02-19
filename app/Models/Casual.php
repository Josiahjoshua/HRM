<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Casual extends Model
{
    use HasFactory;
    protected $table = 'casuals';

    protected $fillable = ['id', 'worker_name','amount','start_date'.'end_date'];

    public function casualDetails()
    {
        return $this->hasMany(CasualDetail::class);
    }

}
