<?php

namespace TypiCMS\Modules\Projects\Http\Controllers;

use Illuminate\Support\Facades\Request;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Projects\Models\Project;
use TypiCMS\Modules\Projects\Repositories\EloquentProject as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * List resources.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $models = $this->repository->all(['category'], true);

        return response()->json($models, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $model = $this->repository->create(Request::all());
        $error = $model ? false : true;

        return response()->json([
            'error' => $error,
            'model' => $model,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $model
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update()
    {
        $updated = $this->repository->update(Request::all());

        return response()->json([
            'error' => !$updated,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \TypiCMS\Modules\Projects\Models\Project $project
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Project $project)
    {
        $deleted = $this->repository->delete($project);

        return response()->json([
            'error' => !$deleted,
        ]);
    }
}
