<?php

namespace App\Admin\Repositories;

use App\Models\Secret as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Secret extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
