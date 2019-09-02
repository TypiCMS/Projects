<?php

namespace TypiCMS\Modules\Projects\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\Filter;
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
            ->allowedFilters([
                Filter::custom('title', FilterOr::class),
            ])
            ->allowedIncludes('image')
            ->translated($request->input('translatable_fields'))
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(ProjectCategory $category, Request $request): JsonResponse
    {
        $data = [];
        foreach ($request->all() as $column => $content) {
            if (is_array($content)) {
                foreach ($content as $key => $value) {
                    $data[$column.'->'.$key] = $value;
                }
            } else {
                $data[$column] = $content;
            }
        }

        foreach ($data as $key => $value) {
            $category->$key = $value;
        }
        $saved = $category->save();

        return response()->json([
            'error' => !$saved,
        ]);
    }

    public function destroy(ProjectCategory $category): JsonResponse
    {
        $deleted = $category->delete();

        return response()->json([
            'error' => !$deleted,
        ]);
    }
}
