<?php

namespace TypiCMS\Modules\Projects\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Projects\Models\Project;

class ApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(Project::class)
            ->selectFields($request->input('fields.projects'))
            ->allowedSorts(['status_translated', 'date', 'title_translated'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->allowedIncludes(['image'])
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(Project $project, Request $request): JsonResponse
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
            $project->$key = $value;
        }
        $saved = $project->save();

        return response()->json([
            'error' => !$saved,
        ]);
    }

    public function destroy(Project $project): JsonResponse
    {
        $deleted = $project->delete();

        return response()->json([
            'error' => !$deleted,
        ]);
    }

    public function files(Project $project): Collection
    {
        return $project->files;
    }

    public function attachFiles(Project $project, Request $request): JsonResponse
    {
        return $project->attachFiles($request);
    }

    public function detachFile(Project $project, File $file): void
    {
        $project->detachFile($file);
    }
}
