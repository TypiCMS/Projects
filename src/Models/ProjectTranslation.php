<?php

namespace TypiCMS\Modules\Projects\Models;

use TypiCMS\Modules\Core\Models\BaseTranslation;

class ProjectTranslation extends BaseTranslation
{
    protected $fillable = [
        'title',
        'slug',
        'status',
        'summary',
        'body',
    ];

    /**
     * get the parent model.
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Projects\Models\Project', 'project_id');
    }
}
