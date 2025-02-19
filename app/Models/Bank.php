<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
  
    public $timestamps = false;
    protected $table = 'bank';
      use HasFactory;

    protected $fillable = [
		'id','bank_name','date'    
	];


    public function bankIn()
    {
        return $this->hasMany(BankIn::class,'bank-id','id');
    }

    public function bankOut()
    {
        return $this->hasMany(BankOut::class,'bank-id','id');
    }
  
}
