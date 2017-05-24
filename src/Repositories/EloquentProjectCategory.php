<?php

namespace TypiCMS\Modules\Projects\Repositories;

use TypiCMS\Modules\Projects\Models\ProjectCategory;
use TypiCMS\Modules\Core\Repositories\EloquentRepository;

class EloquentProjectCategory extends EloquentRepository
{
    protected $repositoryId = 'project_categories';

    protected $model = ProjectCategory::class;

    /**
     * Get all categories for select/option.
     *
     * @return array
     */
    public function allForSelect()
    {
        $categories = $this->make()
            ->order()
            ->get()
            ->pluck('title', 'id')
            ->all();

        return ['' => ''] + $categories;
    }

    /**
     * Get all categories and prepare for menu.
     *
     * @param string $uri
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allForMenu($uri = '')
    {
        $categories = $this->findAll();
        $categories->each(function ($category) use ($uri) {
            $category->url = $uri.'/'.$category->slug;
        });

        return $categories;
    }
}
