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
        Route::namespace($this->namespace)->group(function (Router $router) {

            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('projects')) {
                $router->middleware('public')->group(function (Router $router) use ($page) {
                    $options = $page->private ? ['middleware' => 'auth'] : [];
                    foreach (locales() as $lang) {
                        if ($page->translate('status', $lang) && $uri = $page->uri($lang)) {
                            $router->get($uri, $options + ['uses' => 'PublicController@index'])->name($lang.'::index-projects');
                            $router->get($uri.'/{category}', $options + ['uses' => 'PublicController@indexOfCategory'])->name($lang.'::projects-category');
                            $router->get($uri.'/{category}/{slug}', $options + ['uses' => 'PublicController@show'])->name($lang.'::project');
                        }
                    }
                });
            }

            /*
             * Admin routes
             */
            $router->middleware('admin')->prefix('admin')->group(function (Router $router) {
                $router->get('projects', 'AdminController@index')->name('admin::index-projects')->middleware('can:see-all-projects');
                $router->get('projects/create', 'AdminController@create')->name('admin::create-project')->middleware('can:create-project');
                $router->get('projects/{project}/edit', 'AdminController@edit')->name('admin::edit-project')->middleware('can:update-project');
                $router->get('projects/{project}/files', 'AdminController@files')->name('admin::edit-project-files')->middleware('can:update-project');
                $router->post('projects', 'AdminController@store')->name('admin::store-project')->middleware('can:create-project');
                $router->put('projects/{project}', 'AdminController@update')->name('admin::update-project')->middleware('can:update-project');

                $router->get('projects/categories', 'CategoriesAdminController@index')->name('admin::index-project_categories')->middleware('can:see-all-project_categories');
                $router->get('projects/categories/create', 'CategoriesAdminController@create')->name('admin::create-project_category')->middleware('can:create-project_category');
                $router->get('projects/categories/{category}/edit', 'CategoriesAdminController@edit')->name('admin::edit-project_category')->middleware('can:update-project_category');
                $router->post('projects/categories', 'CategoriesAdminController@store')->name('admin::store-project_category')->middleware('can:create-project_category');
                $router->put('projects/categories/{category}', 'CategoriesAdminController@update')->name('admin::update-project_category')->middleware('can:update-project_category');
            });

            /*
             * API routes
             */
            $router->middleware('api')->prefix('api')->group(function (Router $router) {
                $router->middleware('auth:api')->group(function (Router $router) {
                    $router->get('projects', 'ApiController@index')->middleware('can:see-all-projects');
                    $router->patch('projects/{project}', 'ApiController@updatePartial')->middleware('can:update-project');
                    $router->delete('projects/{project}', 'ApiController@destroy')->middleware('can:delete-project');

                    $router->get('projects/{project}/files', 'ApiController@files')->middleware('can:update-project');
                    $router->post('projects/{project}/files', 'ApiController@attachFiles')->middleware('can:update-project');
                    $router->delete('projects/{project}/files/{file}', 'ApiController@detachFile')->middleware('can:update-project');

                    $router->get('projects/categories', 'CategoriesApiController@index')->middleware('can:see-all-project_categories');
                    $router->patch('projects/categories/{category}', 'CategoriesApiController@updatePartial')->middleware('can:update-project_category');
                    $router->post('projects/categories/sort', 'CategoriesApiController@sort')->middleware('can:update-project_category');
                    $router->delete('projects/categories/{category}', 'CategoriesApiController@destroy')->middleware('can:delete-project_category');
                });
            });
        });
    }
}
