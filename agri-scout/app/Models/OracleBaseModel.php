<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class OracleBaseModel extends Model
{
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (is_null($value)) {
            $upperKey = strtoupper($key);
            $lowerKey = strtolower($key);

            if (array_key_exists($upperKey, $this->attributes)) {
                return $this->attributes[$upperKey];
            }

            if (array_key_exists($lowerKey, $this->attributes)) {
                return $this->attributes[$lowerKey];
            }
        }

        return $value;
    }
}
