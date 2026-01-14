<?php

declare(strict_types=1);

namespace TypiCMS\Modules\Projects\Facades;

use Illuminate\Support\Facades\Facade;

class Projects extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Projects';
    }
}
