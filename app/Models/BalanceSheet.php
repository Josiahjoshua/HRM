<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceSheet extends Model
{
  
    public $timestamps = false;
    protected $table = 'balance_sheet';
      use HasFactory;

    protected $fillable = [
		'id','category_name'    
	];


    public function balanceSheetItem()
    {
        return $this->hasMany(BalanceSheetItem::class,'category_id','id');
    }
  
}
