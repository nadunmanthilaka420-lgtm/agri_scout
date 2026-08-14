<?php

namespace App\Models;

class Customer extends OracleBaseModel
{
    protected $table = 'CUSTOMERS';
    protected $primaryKey = 'CUSTOMER_ID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'USER_ID',
        'FULL_NAME',
        'PHONE',
        'EMAIL',
        'ADDRESS',
        'REGISTERED_DATE',
        'STATUS',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'USER_ID', 'USER_ID');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'CUSTOMER_ID', 'CUSTOMER_ID');
    }
}
