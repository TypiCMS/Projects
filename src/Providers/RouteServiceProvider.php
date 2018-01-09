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
                $router->post('projects/sort', 'AdminController@projects')->name('admin::sort-projects');
                $router->patch('projects/{ids}', 'AdminController@ajaxUpdate')->name('admin::update-project-ajax')->middleware('can:update-project');
                $router->delete('projects/{ids}', 'AdminController@destroyMultiple')->name('admin::destroy-project')->middleware('can:delete-project');

                $router->get('projects/categories', 'CategoriesAdminController@index')->name('admin::index-project_categories')->middleware('can:see-all-project_categories');
                $router->get('projects/categories/create', 'CategoriesAdminController@create')->name('admin::create-project_category')->middleware('can:create-project_category');
                $router->get('projects/categories/{category}/edit', 'CategoriesAdminController@edit')->name('admin::edit-project_category')->middleware('can:update-project_category');
                $router->post('projects/categories', 'CategoriesAdminController@store')->name('admin::store-project_category')->middleware('can:create-project_category');
                $router->put('projects/categories/{category}', 'CategoriesAdminController@update')->name('admin::update-project_category')->middleware('can:update-project_category');
                $router->post('projects/categories/sort', 'CategoriesAdminController@sort')->name('admin::sort-project_categories');
                $router->patch('projects/categories/{ids}', 'CategoriesAdminController@ajaxUpdate')->name('admin::update-project_category')->middleware('can:update-project_category');
                $router->delete('projects/categories/{category}', 'CategoriesAdminController@destroyMultiple')->name('admin::destroy-project_category')->middleware('can:delete-project_category');
            });
        });
    }
}
