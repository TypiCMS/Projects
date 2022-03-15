<?php

namespace TypiCMS\Modules\Projects\Composers;

use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
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
                $item->icon = config('typicms.modules.projects.sidebar.icon');
                $item->weight = config('typicms.modules.projects.sidebar.weight');
                $item->route('admin::index-projects');
                $item->append('admin::create-project');
            });
        });
    }
}
