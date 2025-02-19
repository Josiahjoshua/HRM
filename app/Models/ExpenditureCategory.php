<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenditureCategory extends Model
{
  
    public $timestamps = false;
    protected $table = 'expenditure_category';
      use HasFactory;

    protected $fillable = [
		'id','category_name'    
	];

    public function employee()
    {
        return $this->belongsTo('App\Models\User', 'employee_id', 'id');
    }
    public function expenditure()
    {
        return $this->hasMany(Expenditure::class,'category_id','id');
    }
  
}
