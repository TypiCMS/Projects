<?php

namespace TypiCMS\Modules\Projects\Models;

use Exception;
use Laracasts\Presenter\PresentableTrait;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\History\Traits\Historable;

class ProjectCategory extends Base implements Sortable
{
    use HasTranslations;
    use Historable;
    use PresentableTrait;
    use SortableTrait;

    protected $presenter = 'TypiCMS\Modules\Projects\Presenters\CategoryPresenter';

    protected $guarded = ['id', 'exit'];

    public $translatable = [
        'title',
        'slug',
        'status',
    ];

    public $sortable = [
        'order_column_name' => 'position',
    ];

    protected $appends = ['thumb', 'title_translated', 'status_translated'];

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
     * Append thumb attribute.
     *
     * @return string
     */
    public function getThumbAttribute()
    {
        return $this->present()->thumbSrc(null, 22);
    }

    /**
     * Get edit url of model.
     *
     * @return string|void
     */
    public function editUrl()
    {
        try {
            return route('admin::edit-project_category', [$this->id]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Get back office’s index of models url.
     *
     * @return string|void
     */
    public function indexUrl()
    {
        try {
            return route('admin::index-project_categories');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * A category has many projects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'category_id')->order();
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
