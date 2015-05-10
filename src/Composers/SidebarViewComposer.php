<?php
namespace TypiCMS\Modules\Projects\Composers;

use Illuminate\Contracts\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;
use TypiCMS\Modules\Core\Composers\BaseSidebarViewComposer;

class SidebarViewComposer extends BaseSidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('global.menus.content'), function (SidebarGroup $group) {
            $group->addItem(trans('projects::global.name'), function (SidebarItem $item) {
                $item->icon = config('typicms.projects.sidebar.icon', 'icon fa fa-fw fa-cube');
                $item->weight = config('typicms.projects.sidebar.weight');
                $item->route('admin.projects.index');
                $item->append('admin.projects.create');
                $item->authorize(
                    $this->auth->hasAccess('projects.index')
                );
            });
        });
    }
}
