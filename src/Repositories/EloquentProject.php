<?php

namespace TypiCMS\Modules\Projects\Repositories;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Core\Repositories\RepositoriesAbstract;

class EloquentProject extends RepositoriesAbstract implements ProjectInterface
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
