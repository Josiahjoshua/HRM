<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assetlist extends Model
{
    use HasFactory;
    protected $table = 'assetlist';
    public $timestamps = false;
    protected $fillable = [
        'id', 'asset_id',
        'asset_name',
        'asset_model',
        'asset_brand',
        'asset_code',
        'configuration',
        'purchase_date',
        'price',
        'quantity',
        'remain_quantity',
        'depr_rate',
        'depr_interval',
    ];

    public function asset()
    {
        return $this->belongsTo('App\Models\Asset', 'asset_id', 'id');
    }
    public function depreciations()
    {
        return $this->hasMany(Depreciation::class, 'assetlist_id')->orderBy('depreciations.created_at', 'ASC');
    }
    public function asset_employees()
    {
        return $this->hasMany(EmployeeAsset::class, 'assetlist_id', 'id');
    }
    
        public function user()
    {
        return $this->belongsTo('App\Models\User', 'employee_id', 'id');
    }


    
}
