<?php

declare(strict_types=1);

namespace TypiCMS\Modules\Projects\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Projects\Models\Project;
use TypiCMS\Modules\Projects\Models\ProjectCategory;

final class CategoriesApiController extends BaseApiController
{
    /** @return LengthAwarePaginator<int, mixed> */
    public function index(Request $request): LengthAwarePaginator
    {
        $query = ProjectCategory::query()->selectFields();

        return QueryBuilder::for($query)
            ->allowedSorts(['status_translated', 'position', 'title_translated'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->allowedIncludes(['image'])
            ->paginate($request->integer('per_page'));
    }

    protected function updatePartial(ProjectCategory $category, Request $request): void
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

    public function destroy(ProjectCategory $category): JsonResponse
    {
        if ($category->projects->count() > 0) {
            return response()->json(['message' => 'This category cannot be deleted as it contains projects.'], 403);
        }

        $category->delete();

        return response()->json(status: 204);
    }
}
