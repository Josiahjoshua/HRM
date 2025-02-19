<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    use HasFactory;
    protected $table = 'cash';
   
    protected $fillable = ['amount', 'type', 'source_destination', 'othersource_destination', 'date','description'];


  public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function pettyCash()
    {
        return $this->belongsTo(PettyCash::class);
    }
  
}