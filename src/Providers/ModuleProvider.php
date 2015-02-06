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
use TypiCMS\Modules\Projects\Services\Form\ProjectForm;
use TypiCMS\Modules\Projects\Services\Form\ProjectFormLaravelValidator;
use TypiCMS\Observers\FileObserver;
use TypiCMS\Observers\SlugObserver;
use TypiCMS\Services\Cache\LaravelCache;
use View;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {
        // Bring in the routes
        require __DIR__ . '/../routes.php';

        // Add dirs
        View::addNamespace('projects', __DIR__ . '/../views/');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'projects');
        $this->publishes([
            __DIR__ . '/../config/' => config_path('typicms/projects'),
        ], 'config');
        $this->publishes([
            __DIR__ . '/../migrations/' => base_path('/database/migrations'),
        ], 'migrations');

        AliasLoader::getInstance()->alias(
            'Projects',
            'TypiCMS\Modules\Projects\Facades\Facade'
        );

        // Observers
        ProjectTranslation::observe(new SlugObserver);
        Project::observe(new FileObserver);
    }

    public function register()
    {

        $app = $this->app;

        /**
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Projects\Composers\SideBarViewComposer');

        $app->bind('TypiCMS\Modules\Projects\Repositories\ProjectInterface', function (Application $app) {
            $repository = new EloquentProject(
                new Project,
                $app->make('TypiCMS\Modules\Tags\Repositories\TagInterface')
            );
            if (! Config::get('app.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], ['projects', 'tags'], 10);

            return new CacheDecorator($repository, $laravelCache);
        });

        $app->bind('TypiCMS\Modules\Projects\Services\Form\ProjectForm', function (Application $app) {
            return new ProjectForm(
                new ProjectFormLaravelValidator($app['validator']),
                $app->make('TypiCMS\Modules\Projects\Repositories\ProjectInterface')
            );
        });

    }
}
