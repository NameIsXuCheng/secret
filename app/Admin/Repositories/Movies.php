<?php

namespace App\Admin\Repositories;

use App\Models\Movies as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Movies extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
