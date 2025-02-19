<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenditure extends Model
{
  
    public $timestamps = false;
    protected $table = 'expenditure';
      use HasFactory;

    protected $fillable = [
		'id','desc','for','amount', 'date','category_id' 
	];

  public function expenditurecategory()
  {
    return $this->belongsTo(ExpenditureCategory::class, 'id','category_id');
  }
  
}
