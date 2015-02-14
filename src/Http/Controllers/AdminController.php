<?php
namespace TypiCMS\Modules\Projects\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use JavaScript;
use Response;
use Session;
use TypiCMS\Http\Controllers\AdminSimpleController;
use TypiCMS\Modules\Projects\Repositories\ProjectInterface;
use TypiCMS\Modules\Projects\Services\Form\ProjectForm;
use TypiCMS\Modules\Tags\Models\Tag;
use View;

class AdminController extends AdminSimpleController
{

    public function __construct(ProjectInterface $project, ProjectForm $projectform)
    {
        parent::__construct($project, $projectform);
        $this->title['parent'] = trans_choice('projects::global.projects', 2);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        JavaScript::put([
            'tags' => Tag::lists('tag')
        ]);

        $model = $this->repository->getModel();
        return view('core::admin.create')
            ->with(compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Model    $model
     * @return Response
     */
    public function edit($model)
    {
        JavaScript::put([
            'tags' => Tag::lists('tag')
        ]);

        return view('core::admin.edit')
            ->with(compact('model'));
    }
}
