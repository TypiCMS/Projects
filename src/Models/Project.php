<?php

namespace TypiCMS\Modules\Projects\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\History\Traits\Historable;

class Project extends Base
{
    use HasTranslations;
    use Historable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Projects\Presenters\ModulePresenter';

    protected $dates = ['date'];

    protected $guarded = ['id', 'exit', 'tags', 'galleries'];

    public $translatable = [
        'title',
        'slug',
        'status',
        'summary',
        'body',
    ];

    protected $appends = ['thumb', 'title_translated', 'category_name'];

    public $attachments = [
        'image',
    ];

    /**
     * Get public uri.
     *
     * @return string|null
     */
    public function uri($locale = null)
    {
        $locale = $locale ?: config('app.locale');
        $page = TypiCMS::getPageLinkedToModule($this->getTable());
        if ($page) {
            return $page->uri($locale).'/'.$this->category->translate('slug', $locale).'/'.$this->translate('slug', $locale);
        }

        return '/';
    }

    /**
     * A project belongs to a category.
     *
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ProjectCategory::class);
    }

    /**
     * A project has many galleries.
     *
     * @return MorphToMany
     */
    public function galleries()
    {
        return $this->morphToMany('TypiCMS\Modules\Galleries\Models\Gallery', 'galleryable')
            ->withPivot('position')
            ->orderBy('position')
            ->withTimestamps();
    }

    /**
     * Append title_translated attribute.
     *
     * @return string
     */
    public function getTitleTranslatedAttribute()
    {
        $locale = config('app.locale');
        return $this->translate('title', config('typicms.content_locale', $locale));
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

    /**
     * Append category_name attribute.
     *
     * @return string
     */
    public function getCategoryNameAttribute()
    {
        return $this->category->title ?? null;
    }
}
