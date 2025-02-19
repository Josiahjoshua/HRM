<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasualPaymentDetails extends Model
{
    use HasFactory;
    protected $table = 'casual_payment_details';

    protected $fillable = ['id', 'paid_amount','remaining_amount','casual_id','dateofPay','description'];

    public function casual()
    {
        return $this->belongsTo(Casual::class,'casual_id','id');
    }
    public function casualDetails()
    {
        return $this->belongsTo(Casual::class,'casual_id','id');
    }

}
