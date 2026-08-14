<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Crop extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'crops';

    protected $fillable = [
        'farm_id',
        'crop_name',
        'variety',
        'category',
        'planting_date',
        'expected_harvest_date',
        'current_stage',
        'area_acres',
        'estimated_yield',
        'yield_unit',
        'status',
        'created_at',
        'updated_at',
    ];
}
