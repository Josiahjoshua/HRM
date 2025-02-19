<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Holiday extends Model 
{
    use HasFactory;
    protected $table = 'holiday';
    public $timestamps = false;
    protected $fillable = [
		'name','date',   
	];


}