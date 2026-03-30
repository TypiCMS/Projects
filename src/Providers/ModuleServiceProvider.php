<?php

declare(strict_types=1);

namespace TypiCMS\Modules\Projects\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Models\Tag;
use TypiCMS\Modules\Projects\Composers\SidebarViewComposer;
use TypiCMS\Modules\Projects\Models\Project;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/projects.php', 'typicms.modules.projects');
        $this->mergeConfigFrom(__DIR__ . '/../config/project_categories.php', 'typicms.modules.project_categories');

        $this->loadRoutesFrom(__DIR__ . '/../routes/projects.php');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views/', 'projects');

        $this->publishes([
            __DIR__ . '/../../database/migrations/create_project_categories_table.php.stub' => getMigrationFileName(
                'create_project_categories_table',
            ),
            __DIR__ . '/../../database/migrations/create_projects_table.php.stub' => getMigrationFileName(
                'create_projects_table',
            ),
        ], 'typicms-migrations');
        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/projects'),
        ], 'typicms-views');
        $this->publishes([__DIR__ . '/../../resources/scss' => resource_path('scss')], 'typicms-resources');

        View::composer('core::admin._sidebar', SidebarViewComposer::class);

        // A project have tags.
        Tag::resolveRelationUsing('projects', fn ($tag) => $tag->morphedByMany(Project::class, 'taggable'));

        // Add the page in the view.
        View::composer('projects::public.*', function ($view): void {
            $view->page = getPageLinkedToModule('projects');
        });
    }
}
