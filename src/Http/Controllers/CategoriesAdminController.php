<?php

declare(strict_types=1);

namespace TypiCMS\Modules\Projects\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Projects\Http\Requests\CategoryFormRequest;
use TypiCMS\Modules\Projects\Models\Project;
use TypiCMS\Modules\Projects\Models\ProjectCategory;

final class CategoriesAdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('projects::admin.index-categories');
    }

    public function create(): View
    {
        $model = new ProjectCategory();

        return view('projects::admin.create-category', ['model' => $model]);
    }

    public function edit(ProjectCategory $category): View
    {
        return view('projects::admin.edit-category', ['model' => $category]);
    }

    public function store(CategoryFormRequest $request): RedirectResponse
    {
        $category = ProjectCategory::query()->create($request->validated());

        return $this->redirect($request, $category)->withMessage(__('Item successfully created.'));
    }

    public function update(ProjectCategory $category, CategoryFormRequest $request): RedirectResponse
    {
        $category->update($request->validated());
        (new Project())->flushCache();

        return $this->redirect($request, $category)->withMessage(__('Item successfully updated.'));
    }
}
