<?php

namespace TypiCMS\Modules\Projects\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Projects\Http\Requests\FormRequest;
use TypiCMS\Modules\Projects\Models\Project;
use TypiCMS\Modules\Projects\Repositories\EloquentProject;

class ApiController extends BaseApiController
{
    public function __construct(EloquentProject $project)
    {
        parent::__construct($project);
    }

    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = QueryBuilder::for(Project::class)
            ->allowedFilters('start_date')
            ->translated($request->input('translatable_fields'))
            ->with('files')
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

        $this->repository->forgetCache();

        return response()->json([
            'error' => !$saved,
        ]);
    }

    public function destroy(Project $project)
    {
        $deleted = $this->repository->delete($project);

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
        return $this->repository->attachFiles($project, $request);
    }

    public function detachFile(Project $project, File $file)
    {
        return $this->repository->detachFile($project, $file);
    }
}
