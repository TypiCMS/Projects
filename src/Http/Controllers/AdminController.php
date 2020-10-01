<?php

namespace TypiCMS\Modules\Projects\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Projects\Exports\Export;
use TypiCMS\Modules\Projects\Http\Requests\FormRequest;
use TypiCMS\Modules\Projects\Models\Project;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('projects::admin.index');
    }

    public function export(Request $request)
    {
        $filename = date('Y-m-d').' '.config('app.name').' projects.xlsx';

        return Excel::download(new Export($request), $filename);
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
        $project = Project::create($request->validated());

        return $this->redirect($request, $project);
    }

    public function update(Project $project, FormRequest $request): RedirectResponse
    {
        $project->update($request->validated());

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
