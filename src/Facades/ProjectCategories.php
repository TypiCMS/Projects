<?php

namespace TypiCMS\Modules\Projects\Facades;

use Illuminate\Support\Facades\Facade;

class ProjectCategories extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ProjectCategories';
    }
}
