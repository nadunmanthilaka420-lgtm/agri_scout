<?php

namespace App\Models;

class FieldOfficer extends OracleBaseModel
{
    protected $table = 'FIELD_OFFICERS';
    protected $primaryKey = 'OFFICER_ID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'USER_ID',
        'EMPLOYEE_NO',
        'FULL_NAME',
        'PHONE',
        'EMAIL',
        'ASSIGNED_AREA',
        'JOINED_DATE',
        'STATUS',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'USER_ID', 'USER_ID');
    }

    public function visits()
    {
        return $this->hasMany(OfficerVisit::class, 'OFFICER_ID', 'OFFICER_ID');
    }
}
