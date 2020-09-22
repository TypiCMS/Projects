<?php

namespace TypiCMS\Modules\Projects\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        if (Gate::denies('read projects')) {
            return;
        }
        $view->sidebar->group(__('Content'), function (SidebarGroup $group) {
            $group->id = 'content';
            $group->weight = 30;
            $group->addItem(__('Projects'), function (SidebarItem $item) {
                $item->id = 'projects';
                $item->icon = config('typicms.projects.sidebar.icon');
                $item->weight = config('typicms.projects.sidebar.weight');
                $item->route('admin::index-projects');
                $item->append('admin::create-project');
            });
        });
    }
}
