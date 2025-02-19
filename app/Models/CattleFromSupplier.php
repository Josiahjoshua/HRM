<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CattleFromSupplier extends Model
{
    protected $table = 'cattlefromsupplier';
    protected $fillable = ['id', 'supplier_id','tax','letter','date'];

    
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id','id');
    }
    public function cattleAdded(){
        return $this->hasMany(CattleAdded::class);

    }

}
