<?php
namespace TypiCMS\Modules\Projects\Http\Controllers;

use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Projects\Http\Requests\FormRequest;
use TypiCMS\Modules\Projects\Repositories\ProjectInterface as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Get models
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function index()
    {
        $models = $this->repository->all(['category'], true);
        return response()->json($models, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FormRequest $request
     * @return Model|false
     */
    public function store(FormRequest $request)
    {
        $model = $this->repository->create(Input::all());
        $error = $model ? false : true ;
        return response()->json([
            'error' => $error,
            'model' => $model,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $model
     * @param  FormRequest $request
     * @return boolean
     */
    public function update($model, FormRequest $request)
    {
        $error = $this->repository->update($request->all()) ? false : true ;
        return response()->json([
            'error' => $error,
        ], 200);
    }
}
