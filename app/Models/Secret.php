<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Secret extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'secret';

    public function interfaces()
    {
        return $this->belongsToMany(Interfaces::class, 'id');
    }
}
