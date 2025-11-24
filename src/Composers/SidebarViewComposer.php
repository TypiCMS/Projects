<?php

namespace TypiCMS\Modules\Projects\Composers;

use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use TypiCMS\Modules\Sidebar\SidebarGroup;
use TypiCMS\Modules\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view): void
    {
        if (Gate::denies('read projects')) {
            return;
        }
        $view->offsetGet('sidebar')->group(__(config('typicms.modules.projects.sidebar.group', 'Content')), function (SidebarGroup $group): void {
            $group->id = 'content';
            $group->weight = 30;
            $group->addItem(__(config('typicms.modules.projects.sidebar.label', 'Projects')), function (SidebarItem $item): void {
                $item->id = 'projects';
                $item->icon = config('typicms.modules.projects.sidebar.icon');
                $item->weight = config('typicms.modules.projects.sidebar.weight');
                $item->route('admin::index-projects');
            });
        });
    }
}
