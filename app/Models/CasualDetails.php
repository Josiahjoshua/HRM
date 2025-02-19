<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasualDetails extends Model
{
    use HasFactory;
    protected $table = 'casual_details';

    protected $fillable = ['id', 'date','hours','casual_id'];

    public function casual()
    {
        return $this->belongsTo(Casual::class,'casual_id','id');
    }

}
