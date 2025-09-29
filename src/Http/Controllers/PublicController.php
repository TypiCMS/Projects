<?php

namespace TypiCMS\Modules\Projects\Http\Controllers;

use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
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
            ->with(['categories' => $categories]);
    }

    public function indexOfCategory(?string $categorySlug = null): View
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
            ->with(['models' => $models, 'category' => $category]);
    }

    public function show(?string $categorySlug = null, ?string $slug = null): View
    {
        $category = ProjectCategory::query()
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
        abort_if($category->id !== $model->category_id, 404);

        return view('projects::public.show')
            ->with(['model' => $model]);
    }
}
