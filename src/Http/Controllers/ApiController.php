<?php

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

class ApiController extends BaseApiController
{
    /** @return LengthAwarePaginator<int, mixed> */
    public function index(Request $request): LengthAwarePaginator
    {
        $query = Project::query()
            ->selectFields()
            ->selectSub(ProjectCategory::query()->select(column('title'))->whereColumn('category_id', 'project_categories.id'), 'category_name');

        return QueryBuilder::for($query)
            ->allowedSorts(['status_translated', 'date', 'title_translated', 'category_name'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->allowedIncludes(['image'])
            ->paginate($request->integer('per_page'));
    }

    protected function updatePartial(Project $project, Request $request): void
    {
        foreach ($request->only('status') as $key => $content) {
            if ($project->isTranslatableAttribute($key)) {
                foreach ($content as $lang => $value) {
                    $project->setTranslation($key, $lang, $value);
                }
            } else {
                $project->{$key} = $content;
            }
        }

        $project->save();
    }

    public function destroy(Project $project): JsonResponse
    {
        $project->delete();

        return response()->json(status: 204);
    }
}
