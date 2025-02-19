<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depreciation extends Model
{
    use HasFactory;
    protected $fillable = [
        'assetlist_id',
        'depr_value',
        'interval',
        'created_at',
        'updated_at'
    ];
}
