<?php

namespace TypiCMS\Modules\Projects\Http\Controllers;

use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Projects\Facades\ProjectCategories;
use TypiCMS\Modules\Projects\Models\ProjectCategory;

class PublicController extends BasePublicController
{
    public function index(): View
    {
        $categories = ProjectCategory::with('image')->all();

        return view('projects::public.index')
            ->with(compact('categories'));
    }

    public function indexOfCategory($categorySlug = null): View
    {
        $category = ProjectCategory::with('image')
            ->where(column('slug'), $categorySlug)
            ->firstOrFails();
        $relatedModels = ['translations', 'category', 'category.translations'];
        $models = $this->model->allBy('category_id', $category->id, $relatedModels, false);

        return view('projects::public.index-of-category')
            ->with(compact('models', 'category'));
    }

    public function show($categorySlug = null, $slug = null): View
    {
        $category = ProjectCategories::with('image')->bySlug($categorySlug);
        $model = Project::with([
                'image',
                'images',
                'documents',
            ])
            ->where(column('slug'), $slug)
            ->firstOrFails();
        if ($category->id != $model->category_id) {
            abort(404);
        }

        return view('projects::public.show')
            ->with(compact('model'));
    }
}
