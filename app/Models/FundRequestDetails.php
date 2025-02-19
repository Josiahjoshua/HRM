<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundRequestDetails extends Model
{
    use HasFactory;

    protected $table = 'fund_request_details';
    protected $fillable = ['fundrequest_id', 'product_name', 'price','Quantity'];

    public function fundrequest()
    {
        return $this->belongsTo(FundRequest::class, 'fundrequest_id','id');
    }



}
