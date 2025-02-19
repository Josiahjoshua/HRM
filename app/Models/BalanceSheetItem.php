<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceSheetItem extends Model
{
  
    public $timestamps = false;
    protected $table = 'balance_sheet_details';
      use HasFactory;

    protected $fillable = [
		'id','item','amount', 'category_id' 
	];

  public function balanceSheet()
  {
    return $this->belongsTo(BalanceSheet::class, 'id','category_id');
  }
  
}
