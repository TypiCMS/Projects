<?php

namespace TypiCMS\Modules\Projects\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Projects\Models\ProjectCategory;

class CategoriesApiController extends BaseApiController
{
    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = QueryBuilder::for(ProjectCategory::class)
            ->allowedFilters([
                Filter::custom('title', FilterOr::class),
            ])
            ->allowedIncludes('image')
            ->translated($request->input('translatable_fields'))
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(ProjectCategory $category, Request $request)
    {
        $data = [];
        foreach ($request->all() as $column => $content) {
            if (is_array($content)) {
                foreach ($content as $key => $value) {
                    $data[$column.'->'.$key] = $value;
                }
            } else {
                $data[$column] = $content;
            }
        }

        foreach ($data as $key => $value) {
            $category->$key = $value;
        }
        $saved = $category->save();

        $this->model->forgetCache();

        return response()->json([
            'error' => !$saved,
        ]);
    }

    public function destroy(ProjectCategory $category)
    {
        $deleted = $category->delete();

        return response()->json([
            'error' => !$deleted,
        ]);
    }
}
