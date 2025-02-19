<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefit_Payslip extends Model
{
    use HasFactory;
    protected $table = 'benefit_payslip';
    protected $fillable = [
        'payslip_id','amount','benefit_name',   
];

public function payslip()
{
   return $this->belongsTo(Payslip::class);
}
public function room()
{
   return $this->belongsTo(Room::class);
}
}
