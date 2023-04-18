<?php

namespace TypiCMS\Modules\Projects\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Core\Models\File;
use TypiCMS\Modules\Core\Traits\HasFiles;
use TypiCMS\Modules\Core\Traits\HasTags;
use TypiCMS\Modules\Core\Traits\HasTerms;
use TypiCMS\Modules\Core\Traits\Historable;
use TypiCMS\Modules\Projects\Presenters\ModulePresenter;

class Project extends Base
{
    use HasFiles;
    use HasTags;
    use HasTerms;
    use HasTranslations;
    use Historable;
    use PresentableTrait;

    protected string $presenter = ModulePresenter::class;

    protected $casts = [
        'date' => 'datetime:Y-m-d',
    ];

    protected $guarded = [];

    protected $appends = ['thumb'];

    public array $translatable = [
        'title',
        'slug',
        'status',
        'summary',
        'body',
    ];

    public function uri($locale = null): string
    {
        $locale = $locale ?: config('app.locale');
        $route = $locale . '::' . Str::singular($this->getTable());
        if (Route::has($route)) {
            return route($route, [$this->category->translate('slug', $locale), $this->translate('slug', $locale)]);
        }

        return url('/');
    }

    protected function thumb(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->present()->image(null, 54),
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image_id');
    }
}
