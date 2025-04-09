<?php

namespace TypiCMS\Modules\Projects\Http\Controllers;

use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Projects\Facades\ProjectCategories;
use TypiCMS\Modules\Projects\Models\Project;
use TypiCMS\Modules\Projects\Models\ProjectCategory;

class PublicController extends BasePublicController
{
    public function index(): View
    {
        $categories = ProjectCategory::query()
            ->published()
            ->order()
            ->with('image')
            ->get();

        return view('projects::public.index')
            ->with(compact('categories'));
    }

    public function indexOfCategory($categorySlug = null): View
    {
        $category = ProjectCategory::query()
            ->published()
            ->with('image')
            ->whereSlugIs($categorySlug)
            ->firstOrFail();
        $models = Project::query()
            ->published()
            ->order()
            ->where('category_id', $category->id)
            ->get();

        return view('projects::public.index-of-category')
            ->with(compact('models', 'category'));
    }

    public function show($categorySlug = null, $slug = null): View
    {
        $category = ProjectCategories::query()
            ->with('image')
            ->whereSlugIs($categorySlug)
            ->firstOrFail();
        $model = Project::query()
            ->published()
            ->with([
                'image',
                'images',
                'documents',
            ])
            ->whereSlugIs($slug)
            ->firstOrFail();
        if ($category->id != $model->category_id) {
            abort(404);
        }

        return view('projects::public.show')
            ->with(compact('model'));
    }
}
