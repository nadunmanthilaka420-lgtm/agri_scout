<?php

namespace App\Models;

class farm extends OracleBaseModel
{
    protected $table = 'FARMS';
    protected $primaryKey = 'FARM_ID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'FARMER_ID',
        'FARM_NAME',
        'FARMNAME',
        'LOCATION',
        'DISTRICT',
        'AREA',
        'CREATED_AT',
        'UPDATED_AT',
    ];

    public function getFarmnameAttribute()
    {
        return $this->attributes['FARM_NAME'] ?? $this->attributes['FARMNAME'] ?? null;
    }

    public function setFarmnameAttribute($value)
    {
        $this->attributes['FARM_NAME'] = $value;
    }

    public function farmer()
    {
        return $this->belongsTo(Farmer::class, 'FARMER_ID', 'FARMER_ID');
    }

    public function visits()
    {
        return $this->hasMany(OfficerVisit::class, 'FARM_ID', 'FARM_ID');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'FARM_ID', 'FARM_ID');
    }
}

if (!class_exists('App\Models\Farm')) {
    class_alias(farm::class, 'App\Models\Farm');
}
