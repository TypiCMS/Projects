<?php

namespace TypiCMS\Modules\Projects\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Projects\Http\Requests\FormRequest;
use TypiCMS\Modules\Projects\Models\Project;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('projects::admin.index');
    }

    public function create(): View
    {
        $model = new Project();

        return view('projects::admin.create')
            ->with(compact('model'));
    }

    public function edit(Project $project): View
    {
        return view('projects::admin.edit')
            ->with([
                'model' => $project,
            ]);
    }

    public function store(FormRequest $request): RedirectResponse
    {
        $project = Project::create($request->all());

        return $this->redirect($request, $project);
    }

    public function update(Project $project, FormRequest $request): RedirectResponse
    {
        $project->update($request->all());

        return $this->redirect($request, $project);
    }

    public function files(Project $project): JsonResponse
    {
        $data = [
            'models' => $project->files,
        ];

        return response()->json($data, 200);
    }
}
