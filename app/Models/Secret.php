<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Secret extends Authenticatable implements JWTSubject
{
	use HasDateTimeFormatter;
    protected $table = 'secret';

    protected $fillable = [
        'app_key', 'app_secret',
    ];

    public function interfaces()
    {
        return $this->belongsToMany(Interfaces::class, 'id');
    }

    //2021-03-29 JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
