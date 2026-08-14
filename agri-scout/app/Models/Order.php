<?php

namespace App\Models;

class Order extends OracleBaseModel
{
    protected $table = 'ORDERS';
    protected $primaryKey = 'ORDER_ID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'CUSTOMER_ID',
        'FARM_ID',
        'ORDER_DATE',
        'CROP_NAME',
        'QUANTITY',
        'UNIT',
        'UNIT_PRICE',
        'TOTAL_AMOUNT',
        'STATUS',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'CUSTOMER_ID', 'CUSTOMER_ID');
    }

    public function farm()
    {
        return $this->belongsTo(farm::class, 'FARM_ID', 'FARM_ID');
    }
}
