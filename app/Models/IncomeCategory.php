<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeCategory extends Model
{
  
    public $timestamps = false;
    protected $table = 'income_category';
      use HasFactory;

    protected $fillable = [
		'id','category_name'    
	];

    public function employee()
    {
        return $this->belongsTo('App\Models\User', 'employee_id', 'id');
    }
  public function income()
  {
      return $this->hasMany(Income::class,'category_id','id');
  }
  
}
