<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class DiseaseReport extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'disease_reports';

    protected $fillable = [
        'farm_id',
        'crop_name',
        'reported_by',
        'disease',
        'reported_date',
        'description',
        'images',
        'treatment',
        'follow_ups',
        'status',
        'created_at',
        'updated_at',
    ];
}
