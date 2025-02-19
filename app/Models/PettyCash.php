<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PettyCash extends Model
{
    use HasFactory;
    protected $table = 'petty_cash';
   
    protected $fillable = ['amount', 'type', 'source_destination', 'othersource_destination', 'date','description'];

  public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function Cash()
    {
        return $this->belongsTo(Cash::class);
    }
  
}