<?php

namespace TypiCMS\Modules\Projects\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Projects\Http\Requests\CategoryFormRequest;
use TypiCMS\Modules\Projects\Models\Project;
use TypiCMS\Modules\Projects\Models\ProjectCategory;

class CategoriesAdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('projects::admin.index-categories');
    }

    public function create(): View
    {
        $model = new ProjectCategory();

        return view('projects::admin.create-category')
            ->with(compact('model'));
    }

    public function edit(ProjectCategory $category): View
    {
        return view('projects::admin.edit-category')
            ->with(['model' => $category]);
    }

    public function store(CategoryFormRequest $request): RedirectResponse
    {
        $category = ProjectCategory::create($request->validated());

        return $this->redirect($request, $category);
    }

    public function update(ProjectCategory $category, CategoryFormRequest $request): RedirectResponse
    {
        $category->update($request->validated());
        (new Project())->flushCache();

        return $this->redirect($request, $category);
    }
}
