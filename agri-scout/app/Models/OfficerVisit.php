<?php

namespace App\Models;

class OfficerVisit extends OracleBaseModel
{
    protected $table = 'OFFICER_VISITS';
    protected $primaryKey = 'VISIT_ID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'OFFICER_ID',
        'FARM_ID',
        'VISIT_DATE',
        'VISIT_TYPE',
        'STATUS',
        'PURPOSE',
        'CREATED_AT',
    ];

    public function officer()
    {
        return $this->belongsTo(FieldOfficer::class, 'OFFICER_ID', 'OFFICER_ID');
    }

    public function farm()
    {
        return $this->belongsTo(farm::class, 'FARM_ID', 'FARM_ID');
    }
}
