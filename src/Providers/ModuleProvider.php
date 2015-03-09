<?php
namespace TypiCMS\Modules\Projects\Providers;

use Config;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Lang;
use TypiCMS\Modules\Projects\Models\Project;
use TypiCMS\Modules\Projects\Models\ProjectTranslation;
use TypiCMS\Modules\Projects\Repositories\CacheDecorator;
use TypiCMS\Modules\Projects\Repositories\EloquentProject;
use TypiCMS\Observers\FileObserver;
use TypiCMS\Observers\SlugObserver;
use TypiCMS\Observers\TagObserver;
use TypiCMS\Services\Cache\LaravelCache;
use View;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {

        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php', 'typicms.projects'
        );

        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'projects');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'projects');

        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/projects'),
        ], 'views');
        $this->publishes([
            __DIR__ . '/../database' => base_path('database'),
        ], 'migrations');
        $this->publishes([
            __DIR__ . '/../../tests' => base_path('tests'),
        ], 'tests');

        AliasLoader::getInstance()->alias(
            'Projects',
            'TypiCMS\Modules\Projects\Facades\Facade'
        );

        // Observers
        ProjectTranslation::observe(new SlugObserver);
        Project::observe(new FileObserver);
        Project::observe(new TagObserver);
    }

    public function register()
    {

        $app = $this->app;

        /**
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Projects\Providers\RouteServiceProvider');

        /**
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Projects\Composers\SidebarViewComposer');

        $app->bind('TypiCMS\Modules\Projects\Repositories\ProjectInterface', function (Application $app) {
            $repository = new EloquentProject(
                new Project
            );
            if (! Config::get('app.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], ['projects', 'tags'], 10);

            return new CacheDecorator($repository, $laravelCache);
        });

    }
}
