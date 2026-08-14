<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ActivityLog extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'activity_logs';

    protected $fillable = [
        'user_id',
        'user_role',
        'action',
        'module',
        'description',
        'record_id',
        'ip_address',
        'user_agent',
        'created_at',
    ];
}
