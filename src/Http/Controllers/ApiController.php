<?php
namespace TypiCMS\Modules\Projects\Http\Controllers;

use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Projects\Repositories\ProjectInterface as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }
}
