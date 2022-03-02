<?php

namespace TypiCMS\Modules\Projects\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Projects\Composers\SidebarViewComposer;
use TypiCMS\Modules\Projects\Facades\ProjectCategories;
use TypiCMS\Modules\Projects\Facades\Projects;
use TypiCMS\Modules\Projects\Models\Project;
use TypiCMS\Modules\Projects\Models\ProjectCategory;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'typicms.projects');
        $this->mergeConfigFrom(__DIR__.'/../config/config-project_categories.php', 'typicms.project_categories');

        $this->mergeConfigFrom(__DIR__.'/../config/permissions.php', 'typicms.permissions');

        config(['typicms.modules.projects' => ['linkable_to_page', 'has_taxonomies']]);

        $this->loadViewsFrom(__DIR__.'/../../resources/views/', 'projects');

        $this->publishes([
            __DIR__.'/../../database/migrations/create_project_categories_table.php.stub' => getMigrationFileName('create_project_categories_table'),
            __DIR__.'/../../database/migrations/create_projects_table.php.stub' => getMigrationFileName('create_projects_table'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/projects'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../../resources/scss' => resource_path('scss'),
        ], 'resources');

        AliasLoader::getInstance()->alias('Projects', Projects::class);
        AliasLoader::getInstance()->alias('ProjectCategories', ProjectCategories::class);

        // Observers
        Project::observe(new SlugObserver());
        ProjectCategory::observe(new SlugObserver());

        View::composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        View::composer('projects::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('projects');
        });
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app->bind('Projects', Project::class);
        $this->app->bind('ProjectCategories', ProjectCategory::class);
    }
}
