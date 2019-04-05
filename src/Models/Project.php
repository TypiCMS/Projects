<?php

namespace TypiCMS\Modules\Projects\Models;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Files\Traits\HasFiles;
use TypiCMS\Modules\History\Traits\Historable;
use TypiCMS\Modules\Projects\Presenters\ModulePresenter;

class Project extends Base
{
    use HasFiles;
    use HasTranslations;
    use Historable;
    use PresentableTrait;

    protected $presenter = ModulePresenter::class;

    protected $dates = ['date'];

    protected $guarded = ['id', 'exit', 'tags'];

    protected $appends = ['thumb', 'category_name'];

    public $translatable = [
        'title',
        'slug',
        'status',
        'summary',
        'body',
    ];

    /**
     * Get public uri.
     *
     * @return string|null
     */
    public function uri($locale = null)
    {
        $locale = $locale ?: config('app.locale');
        $route = $locale.'::'.Str::singular($this->getTable());
        if (Route::has($route)) {
            return route($route, [$this->category->slug, $this->slug]);
        }

        return '/';
    }

    /**
     * Append thumb attribute.
     *
     * @return string
     */
    public function getThumbAttribute()
    {
        return $this->present()->thumbSrc(null, 44);
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
     * This model belongs to one image.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(File::class, 'image_id');
    }
}
