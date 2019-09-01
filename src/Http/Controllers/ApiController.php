<?php

namespace TypiCMS\Modules\Projects\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Projects\Models\Project;

class ApiController extends BaseApiController
{
    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = QueryBuilder::for(Project::class)
            ->allowedFilters([
                Filter::custom('date,title', FilterOr::class),
            ])
            ->allowedIncludes('image')
            ->translated($request->input('translatable_fields'))
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(Project $project, Request $request)
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

        $this->model->forgetCache();

        return response()->json([
            'error' => !$saved,
        ]);
    }

    public function destroy(Project $project)
    {
        $deleted = $project->delete();

        return response()->json([
            'error' => !$deleted,
        ]);
    }

    public function files(Project $project)
    {
        return $project->files;
    }

    public function attachFiles(Project $project, Request $request)
    {
        return $this->model->attachFiles($project, $request);
    }

    public function detachFile(Project $project, File $file)
    {
        return $this->model->detachFile($project, $file);
    }
}
