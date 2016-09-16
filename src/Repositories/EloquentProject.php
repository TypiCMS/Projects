<?php

namespace TypiCMS\Modules\Projects\Repositories;

use TypiCMS\Modules\Projects\Models\Project;

class EloquentProject extends EloquentRepository
{
    protected $repositoryId = 'projects';

    protected $model = Project::class;
}
