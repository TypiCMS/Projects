<?php
namespace TypiCMS\Modules\Projects\Composers;

use Illuminate\View\View;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->menus['content']->put('projects', [
            'weight' => config('typicms.projects.sidebar.weight'),
            'request' => $view->prefix . '/projects*',
            'route' => 'admin.projects.index',
            'icon-class' => 'icon fa fa-fw fa-cube',
            'title' => 'Projects',
        ]);
    }
}
