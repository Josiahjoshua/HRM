<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankIn extends Model
{
  
    public $timestamps = true;
    protected $table = 'bank_in';
      use HasFactory;

    protected $fillable = [
		'id','date','amount','bank_id','source','othersource',    
	];


    public function bank()
    {
        return $this->belongsTo(Bank::class,'bank_id','id');
    }
  
}
