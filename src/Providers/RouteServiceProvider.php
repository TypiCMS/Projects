<?php
namespace TypiCMS\Modules\Projects\Providers;

use Config;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {

    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Projects\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        $router->model('projects', 'TypiCMS\Modules\Projects\Models\Project');
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function($router) {
            /**
             * Front office routes
             */
            $router->group(['before' => 'visitor.publicAccess'], function ($router) {
                $routes = app('TypiCMS.routes');
                foreach (Config::get('translatable.locales') as $lang) {
                    if (isset($routes['projects'][$lang])) {
                        $uri = $routes['projects'][$lang];
                    } else {
                        $uri = 'projects';
                        if (Config::get('app.fallback_locale') != $lang || config('typicms.main_locale_in_url')) {
                            $uri = $lang . '/' . $uri;
                        }
                    }
                    $router->get($uri, array('as' => $lang.'.projects', 'uses' => 'PublicController@index'));
                    $router->get($uri.'/{slug}', array('as' => $lang.'.projects.slug', 'uses' => 'PublicController@show'));
                }
            });

            /**
             * Admin routes
             */
            $router->resource('admin/projects', 'AdminController');

            /**
             * API routes
             */
            $router->resource('api/projects', 'ApiController');
        });
    }

}
