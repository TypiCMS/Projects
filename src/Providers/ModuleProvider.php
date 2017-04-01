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
use TypiCMS\Modules\Projects\Repositories\EloquentProject;
use TypiCMS\Modules\Projects\Repositories\EloquentProjectCategory;
use TypiCMS\Modules\Tags\Observers\TagObserver;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.projects'
        );
        $this->mergeConfigFrom(
            __DIR__.'/../config/config-categories.php', 'typicms.project-categories'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['projects' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'projects');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'projects');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/projects'),
        ], 'views');

        AliasLoader::getInstance()->alias('Projects', Projects::class);
        AliasLoader::getInstance()->alias('ProjectCategories', ProjectCategories::class);

        // Observers
        Project::observe(new SlugObserver());
        Project::observe(new TagObserver());
        ProjectCategory::observe(new SlugObserver());
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register(RouteServiceProvider::class);

        /*
         * Register Tags and Categories
         */
        $app->register('TypiCMS\Modules\Tags\Providers\ModuleProvider');

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        $app->view->composer('projects::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('projects');
        });

        $app->bind('Projects', EloquentProject::class);
        $app->bind('ProjectCategories', EloquentProjectCategory::class);
    }
}
