<?php

namespace TypiCMS\Modules\Projects\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Core\Models\File;
use TypiCMS\Modules\Core\Models\History;
use TypiCMS\Modules\Core\Models\Tag;
use TypiCMS\Modules\Core\Models\Term;
use TypiCMS\Modules\Core\Traits\HasFiles;
use TypiCMS\Modules\Core\Traits\HasTags;
use TypiCMS\Modules\Core\Traits\HasTerms;
use TypiCMS\Modules\Core\Traits\Historable;
use TypiCMS\Modules\Projects\Presenters\ModulePresenter;
use TypiCMS\Translatable\HasTranslations;

/**
 * @property int $id
 * @property int $category_id
 * @property string|null $places
 * @property Carbon $date
 * @property string|null $website
 * @property int|null $og_image_id
 * @property int|null $image_id
 * @property string $status
 * @property string $title
 * @property string $slug
 * @property string $summary
 * @property string $body
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, File> $audios
 * @property-read int|null $audios_count
 * @property-read ProjectCategory $category
 * @property-read Collection<int, File> $documents
 * @property-read int|null $documents_count
 * @property-read Collection<int, File> $files
 * @property-read int|null $files_count
 * @property-read Collection<int, History> $history
 * @property-read int|null $history_count
 * @property-read File|null $image
 * @property-read Collection<int, File> $images
 * @property-read int|null $images_count
 * @property-read File|null $ogImage
 * @property-read Collection<int, Tag> $tags
 * @property-read int|null $tags_count
 * @property-read Collection<int, Term> $terms
 * @property-read int|null $terms_count
 * @property-read mixed $thumb
 * @property-read mixed $translations
 * @property-read Collection<int, File> $videos
 * @property-read int|null $videos_count
 */
class Project extends Base
{
    use HasFiles;
    use HasTags;
    use HasTerms;
    use HasTranslations;
    use Historable;
    use PresentableTrait;

    protected string $presenter = ModulePresenter::class;

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'date' => 'datetime:Y-m-d',
        ];
    }

    protected $guarded = [];

    protected $appends = ['thumb'];

    /** @var array<string> */
    public array $translatable = [
        'title',
        'slug',
        'status',
        'summary',
        'body',
    ];

    /** @var array<string> */
    public array $tipTapContent = [
        'body',
    ];

    public function url(?string $locale = null): string
    {
        $locale ??= app()->getLocale();
        $route = $locale . '::project';
        $slug = $this->translate('slug', $locale);
        $categorySlug = $this->category->translate('slug', $locale);

        return Route::has($route) && $slug && $categorySlug ? url(route($route, [$categorySlug, $slug])) : url('/');
    }

    /** @return Attribute<string, null> */
    protected function thumb(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->present()->image(null, 54),
        );
    }

    /** @return BelongsTo<ProjectCategory, $this> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class);
    }

    /** @return BelongsTo<File, $this> */
    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image_id');
    }

    /** @return BelongsTo<File, $this> */
    public function ogImage(): BelongsTo
    {
        return $this->belongsTo(File::class, 'og_image_id');
    }
}
