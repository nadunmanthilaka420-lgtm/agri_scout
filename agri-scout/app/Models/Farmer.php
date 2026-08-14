<?php

namespace App\Models;

class Farmer extends OracleBaseModel
{
    protected $table = 'FARMERS';
    protected $primaryKey = 'FARMER_ID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'USER_ID',
        'NAME',
        'PHONE',
        'EMAIL',
        'ADDRESS',
        'CREATED_AT',
        'UPDATED_AT',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'USER_ID', 'USER_ID');
    }

    public function farms()
    {
        return $this->hasMany(farm::class, 'FARMER_ID', 'FARMER_ID');
    }
}
