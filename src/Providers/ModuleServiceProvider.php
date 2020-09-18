<?php

namespace TypiCMS\Modules\Projects\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Projects\Composers\SidebarViewComposer;
use TypiCMS\Modules\Projects\Facades\ProjectCategories;
use TypiCMS\Modules\Projects\Facades\Projects;
use TypiCMS\Modules\Projects\Models\Project;
use TypiCMS\Modules\Projects\Models\ProjectCategory;
use TypiCMS\Modules\Tags\Observers\TagObserver;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'typicms.projects');
        $this->mergeConfigFrom(__DIR__.'/../config/permissions.php', 'typicms.permissions');
        $this->mergeConfigFrom(__DIR__.'/../config/config-project_categories.php', 'typicms.project_categories');

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['projects' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'projects');

        $this->publishes([
            __DIR__.'/../database/migrations/create_project_categories_table.php.stub' => getMigrationFileName('create_project_categories_table'),
            __DIR__.'/../database/migrations/create_projects_table.php.stub' => getMigrationFileName('create_projects_table'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/projects'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../resources/scss' => resource_path('scss'),
        ], 'resources');

        AliasLoader::getInstance()->alias('Projects', Projects::class);
        AliasLoader::getInstance()->alias('ProjectCategories', ProjectCategories::class);

        // Observers
        Project::observe(new SlugObserver());
        Project::observe(new TagObserver());
        ProjectCategory::observe(new SlugObserver());

        /*
         * Sidebar view composer
         */
        $this->app->view->composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        $this->app->view->composer('projects::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('projects');
        });
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register(RouteServiceProvider::class);

        $app->bind('Projects', Project::class);
        $app->bind('ProjectCategories', ProjectCategory::class);
    }
}
