<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class VisitReport extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'visit_reports';

    protected $fillable = [
        'visit_id',
        'farm_id',
        'officer_id',
        'report_date',
        'weather',
        'crop_condition',
        'soil_condition',
        'irrigation_status',
        'fertilizer_applied',
        'pest_detected',
        'remarks',
        'recommendations',
        'photos',
        'created_at',
        'updated_at',
    ];
}
