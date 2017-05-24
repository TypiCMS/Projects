<?php

namespace TypiCMS\Modules\Projects\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\History\Traits\Historable;
use TypiCMS\Modules\Projects\Presenters\ModulePresenter;

class Project extends Base
{
    use HasTranslations;
    use Historable;
    use PresentableTrait;

    protected $presenter = ModulePresenter::class;

    protected $dates = ['date'];

    protected $guarded = ['id', 'exit', 'tags'];

    public $translatable = [
        'title',
        'slug',
        'status',
        'summary',
        'body',
    ];

    protected $appends = ['image', 'thumb', 'title_translated', 'category_name', 'status_translated'];

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
     * Append status_translated attribute.
     *
     * @return string
     */
    public function getStatusTranslatedAttribute()
    {
        $locale = config('app.locale');

        return $this->translate('status', config('typicms.content_locale', $locale));
    }

    /**
     * Append image attribute.
     *
     * @return string
     */
    public function getImageAttribute()
    {
        return $this->files->first();
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

    /**
     * A project belongs to a category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ProjectCategory::class);
    }

    /**
     * A news can have many files.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function files()
    {
        return $this->morphToMany(File::class, 'model', 'model_has_files', 'model_id', 'file_id')
            ->orderBy('model_has_files.position');
    }
}
