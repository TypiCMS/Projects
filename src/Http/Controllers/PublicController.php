<?php
namespace TypiCMS\Modules\Projects\Http\Controllers;

use TypiCMS;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Projects\Repositories\ProjectInterface;

class PublicController extends BasePublicController
{

    public function __construct(ProjectInterface $project)
    {
        parent::__construct($project);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function index($category = null)
    {
        $relatedModels = array('translations', 'category', 'category.translations');

        if ($category) {
            $models = $this->repository->allBy('category_id', $category->id, $relatedModels, false);
        } else {
            $models = $this->repository->all($relatedModels, false);
        }

        return view('projects::public.index')
            ->with(compact('models', 'category'));
    }

    /**
     * Show resource.
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function show($category = null, $slug = null)
    {
        $model = $this->repository->bySlug($slug);
        if ($category->id != $model->category_id) {
            abort(404);
        }
        return view('projects::public.show')
            ->with(compact('model'));
    }
}
