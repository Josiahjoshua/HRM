<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'asset';

    protected $fillable = [
		'id','category_type','category_name',    
	];

  public function assetlist()
  {
      return $this->hasOne('Assetlist');
  }
  public function logistic()
  {
      return $this->hasOne('Logistic');
  }
  
}
