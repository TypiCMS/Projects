<?php

namespace TypiCMS\Modules\Projects\Http\Controllers;

use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Projects\Facades\Projects;
use TypiCMS\Modules\Projects\Http\Requests\CategoryFormRequest;
use TypiCMS\Modules\Projects\Models\ProjectCategory;

class CategoriesAdminController extends BaseAdminController
{
    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('projects::admin.index-categories');
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = new;

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
        $category = ::create($request->all());

        return $this->redirect($request, $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \TypiCMS\Modules\Projects\Models\ProjectCategory            $category
     * @param \TypiCMS\Modules\Projects\Http\Requests\CategoryFormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProjectCategory $category, CategoryFormRequest $request)
    {
        ::update($request->id, $request->all());
        Projects::forgetCache();

        return $this->redirect($request, $category);
    }
}
