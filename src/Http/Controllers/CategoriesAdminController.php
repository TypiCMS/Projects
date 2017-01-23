<?php

namespace TypiCMS\Modules\Projects\Http\Controllers;

use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Projects\Http\Requests\CategoryFormRequest;
use TypiCMS\Modules\Projects\Http\Requests\FormRequest;
use TypiCMS\Modules\Projects\Models\ProjectCategory;
use TypiCMS\Modules\Projects\Repositories\EloquentProjectCategory;

class CategoriesAdminController extends BaseAdminController
{
    public function __construct(EloquentProjectCategory $category)
    {
        parent::__construct($category);
    }

    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $models = $this->repository->findAllTranslated();
        app('JavaScript')->put('models', $models);

        return view('projects::admin.index-categories');
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = $this->repository->createModel();

        return view('projects::admin.create-category')
            ->with(compact('model'));
    }

    /**
     * Edit form for the specified resource.
     *
     * @param \TypiCMS\Modules\Projects\Models\ProjectCategory $category
     *
     * @return \Illuminate\View\View
     */
    public function edit(ProjectCategory $category)
    {
        return view('projects::admin.edit-category')
            ->with(['model' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \TypiCMS\Modules\Projects\Http\Requests\CategoryFormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryFormRequest $request)
    {
        $category = $this->repository->create($request->all());

        return $this->redirect($request, $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \TypiCMS\Modules\Projects\Models\ProjectCategory           $category
     * @param \TypiCMS\Modules\Projects\Http\Requests\CategoryFormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProjectCategory $category, CategoryFormRequest $request)
    {
        $this->repository->update($request->id, $request->all());

        return $this->redirect($request, $category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \TypiCMS\Modules\Projects\Models\ProjectCategory $category
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ProjectCategory $category)
    {
        $deleted = $this->repository->delete($category);

        return response()->json([
            'error' => !$deleted,
        ]);
    }
}
