<?php

namespace TypiCMS\Modules\Projects\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Route;
use Laracasts\Presenter\PresentableTrait;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Core\Models\File;
use TypiCMS\Modules\Core\Traits\Historable;
use TypiCMS\Modules\Projects\Presenters\CategoryPresenter;

class ProjectCategory extends Base implements Sortable
{
    use HasTranslations;
    use Historable;
    use PresentableTrait;
    use SortableTrait;

    protected $presenter = CategoryPresenter::class;

    protected $guarded = [];

    protected $appends = ['thumb'];

    public $translatable = [
        'title',
        'slug',
        'status',
    ];

    public $sortable = [
        'order_column_name' => 'position',
    ];

    public function allForSelect(): array
    {
        $categories = $this->order()
            ->get()
            ->pluck('title', 'id')
            ->all();

        return ['' => ''] + $categories;
    }

    protected function thumb(): Attribute
    {
        return new Attribute(
            get: fn () => $this->present()->image(null, 54),
        );
    }

    public function editUrl(): string
    {
        $route = 'admin::edit-project_category';
        if (Route::has($route)) {
            return route($route, $this->id);
        }

        return route('admin::dashboard');
    }

    public function indexUrl(): string
    {
        $route = 'admin::index-project_categories';
        if (Route::has($route)) {
            return route($route);
        }

        return route('admin::dashboard');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'category_id')->order();
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image_id');
    }
}
