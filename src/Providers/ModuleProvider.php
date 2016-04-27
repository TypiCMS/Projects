<?php

namespace TypiCMS\Modules\Projects\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\FileObserver;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Core\Services\Cache\LaravelCache;
use TypiCMS\Modules\Projects\Models\Project;
use TypiCMS\Modules\Projects\Repositories\CacheDecorator;
use TypiCMS\Modules\Projects\Repositories\EloquentProject;
use TypiCMS\Modules\Tags\Observers\TagObserver;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.projects'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['projects' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'projects');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'projects');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/projects'),
        ], 'views');
        $this->publishes([
            __DIR__.'/../database' => base_path('database'),
        ], 'migrations');

        AliasLoader::getInstance()->alias(
            'Projects',
            'TypiCMS\Modules\Projects\Facades\Facade'
        );

        // Observers
        Project::observe(new SlugObserver());
        Project::observe(new FileObserver());
        Project::observe(new TagObserver());
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Projects\Providers\RouteServiceProvider');

        /*
         * Register Tags and Categories
         */
        $app->register('TypiCMS\Modules\Tags\Providers\ModuleProvider');
        $app->register('TypiCMS\Modules\Categories\Providers\ModuleProvider');

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Projects\Composers\SidebarViewComposer');

        /*
         * Add the page in the view.
         */
        $app->view->composer('projects::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('projects');
        });

        $app->bind('TypiCMS\Modules\Projects\Repositories\ProjectInterface', function (Application $app) {
            $repository = new EloquentProject(
                new Project()
            );
            if (!config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], ['projects', 'tags'], 10);

            return new CacheDecorator($repository, $laravelCache);
        });
    }
}
