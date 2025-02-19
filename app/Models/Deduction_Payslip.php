<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction_Payslip extends Model
{
    use HasFactory;
    
    protected $table = 'deduction_payslip';
    protected $fillable = [
        'payslip_id','amount','deduction_name',   
];

public function payslip()
{
   return $this->belongsTo(Payslip::class);
}

}
