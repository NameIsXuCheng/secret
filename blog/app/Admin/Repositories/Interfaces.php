<?php

namespace App\Admin\Repositories;

use App\Models\Interfaces as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Interfaces extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
