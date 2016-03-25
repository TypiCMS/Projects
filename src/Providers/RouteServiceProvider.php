<?php

namespace TypiCMS\Modules\Projects\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use TypiCMS\Modules\Core\Facades\TypiCMS;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Projects\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function (Router $router) {

            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('projects')) {
                $options = $page->private ? ['middleware' => 'auth'] : [];
                foreach (config('translatable.locales') as $lang) {
                    if ($page->translate($lang)->status && $uri = $page->uri($lang)) {
                        $router->get($uri, $options + ['as' => $lang.'.projects', 'uses' => 'PublicController@categories']);
                        $router->get($uri.'/{category}', $options + ['as' => $lang.'.projects.category', 'uses' => 'PublicController@index']);
                        $router->get($uri.'/{category}/{slug}', $options + ['as' => $lang.'.projects.category.slug', 'uses' => 'PublicController@show']);
                    }
                }
            }

            /*
             * Admin routes
             */
            $router->get('admin/projects', ['as' => 'admin.projects.index', 'uses' => 'AdminController@index']);
            $router->get('admin/projects/create', ['as' => 'admin.projects.create', 'uses' => 'AdminController@create']);
            $router->get('admin/projects/{project}/edit', ['as' => 'admin.projects.edit', 'uses' => 'AdminController@edit']);
            $router->post('admin/projects', ['as' => 'admin.projects.store', 'uses' => 'AdminController@store']);
            $router->put('admin/projects/{project}', ['as' => 'admin.projects.update', 'uses' => 'AdminController@update']);
            $router->post('admin/projects/sort', ['as' => 'admin.projects.sort', 'uses' => 'AdminController@projects']);

            /*
             * API routes
             */
            $router->get('api/projects', ['as' => 'api.projects.index', 'uses' => 'ApiController@index']);
            $router->put('api/projects/{project}', ['as' => 'api.projects.update', 'uses' => 'ApiController@update']);
            $router->delete('api/projects/{project}', ['as' => 'api.projects.destroy', 'uses' => 'ApiController@destroy']);
        });
    }
}
