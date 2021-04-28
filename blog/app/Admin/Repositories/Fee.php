<?php

namespace App\Admin\Repositories;

use App\Models\Fee as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Fee extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
