<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundRequest extends Model
{
    use HasFactory;

    protected $table = 'fund_request';
    protected $fillable = ['reason', 'amount','date','employee_id'];

    public function fundrequestdetails()
    {
        return $this->hasMany(FundRequestDetails::class,'fundrequest_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }



}
