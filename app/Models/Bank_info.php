<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bank_info extends Model 
{

    use HasFactory;
    protected $table = 'bank_info';
    public $timestamps = false;
    protected $fillable = [
		'employee_id','holder_name','bank_name' ,'branch_name','account_number' , 'account_type',
	];


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

}