<?php

namespace TypiCMS\Modules\Projects\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Projects\Models\Project;
use TypiCMS\Modules\Projects\Models\ProjectCategory;

class CategoriesApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(ProjectCategory::class)
            ->selectFields($request->input('fields.project_categories'))
            ->allowedSorts(['status_translated', 'position', 'title_translated'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->allowedIncludes(['image'])
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(ProjectCategory $category, Request $request)
    {
        foreach ($request->only('status', 'position') as $key => $content) {
            if ($category->isTranslatableAttribute($key)) {
                foreach ($content as $lang => $value) {
                    $category->setTranslation($key, $lang, $value);
                }
            } else {
                $category->{$key} = $content;
            }
        }
        (new Project())->flushCache();
        $category->save();
    }

    public function destroy(ProjectCategory $category)
    {
        if ($category->projects->count() > 0) {
            return response(['message' => 'This category cannot be deleted as it contains projects.'], 403);
        }
        $category->delete();
    }
}
