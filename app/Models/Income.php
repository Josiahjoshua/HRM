<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
  
    public $timestamps = false;
    protected $table = 'income';
      use HasFactory;

    protected $fillable = [
		'id','desc','from','amount', 'date','category_id' 
	];

public function incomecategory()
{
  return $this->belongsTo(IncomeCategory::class, 'id','category_id');
}
  
}
