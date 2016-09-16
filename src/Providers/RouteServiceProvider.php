<?php

namespace TypiCMS\Modules\Projects\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
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
     * @return null
     */
    public function map()
    {
        Route::group(['namespace' => $this->namespace], function (Router $router) {

            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('projects')) {
                $options = $page->private ? ['middleware' => 'auth'] : [];
                foreach (config('translatable-bootforms.locales') as $lang) {
                    if ($page->translate('status', $lang) && $uri = $page->uri($lang)) {
                        $router->get($uri, $options + ['as' => $lang.'.projects', 'uses' => 'PublicController@categories']);
                        $router->get($uri.'/{category}', $options + ['as' => $lang.'.projects.category', 'uses' => 'PublicController@index']);
                        $router->get($uri.'/{category}/{slug}', $options + ['as' => $lang.'.projects.category.slug', 'uses' => 'PublicController@show']);
                    }
                }
            }

            /*
             * Admin routes
             */
            $router->get('admin/projects', 'AdminController@index')->name('admin::index-projects');
            $router->get('admin/projects/create', 'AdminController@create')->name('admin::create-project');
            $router->get('admin/projects/{project}/edit', 'AdminController@edit')->name('admin::edit-project');
            $router->post('admin/projects', 'AdminController@store')->name('admin::store-project');
            $router->put('admin/projects/{project}', 'AdminController@update')->name('admin::update-project');
            $router->post('admin/projects/sort', 'AdminController@projects')->name('admin::sort-projects');

            /*
             * API routes
             */
            $router->get('api/projects', 'ApiController@index')->name('api::index-projects');
            $router->put('api/projects/{project}', 'ApiController@update')->name('api::update-project');
            $router->delete('api/projects/{project}', 'ApiController@destroy')->name('api::destroy-project');
        });
    }
}
