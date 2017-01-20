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
        $view->sidebar->group(__('global.menus.content'), function (SidebarGroup $group) {
            $group->addItem(__('projects::global.name'), function (SidebarItem $item) {
                $item->id = 'projects';
                $item->icon = config('typicms.projects.sidebar.icon', 'icon fa fa-fw fa-cube');
                $item->weight = config('typicms.projects.sidebar.weight');
                $item->route('admin::index-projects');
                $item->append('admin::create-project');
                $item->authorize(
                    Gate::allows('index-projects')
                );
            });
        });
    }
}
