<?php

namespace TypiCMS\Modules\Projects\Models;

use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\History\Traits\Historable;

class ProjectCategory extends Base
{
    use HasTranslations;
    use Historable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Projects\Presenters\CategoryPresenter';

    protected $guarded = ['id', 'exit', 'galleries'];

    public $translatable = [
        'title',
        'slug',
        'status',
    ];

    protected $appends = ['thumb'];

    public $attachments = [
        'image',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class)->order();
    }

    /**
     * Append thumb attribute.
     *
     * @return string
     */
    public function getThumbAttribute()
    {
        return $this->present()->thumbSrc(null, 22);
    }
}
