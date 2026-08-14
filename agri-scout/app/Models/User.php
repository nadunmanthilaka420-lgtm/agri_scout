<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'USERS';

    protected $primaryKey = 'USER_ID';

    public $timestamps = false;

    protected $fillable = [
        'NAME',
        'EMAIL',
        'PASSWORD',
        'ROLE',
        'STATUS',
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'PASSWORD',
        'password',
    ];

    public function getAuthPassword()
    {
        return $this->password ?? $this->PASSWORD;
    }

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

    public function customer()
    {
        return $this->hasOne(Customer::class, 'USER_ID', 'USER_ID');
    }
}
