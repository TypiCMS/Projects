<?php

namespace TypiCMS\Modules\Projects\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Projects\Http\Controllers\AdminController;
use TypiCMS\Modules\Projects\Http\Controllers\ApiController;
use TypiCMS\Modules\Projects\Http\Controllers\CategoriesAdminController;
use TypiCMS\Modules\Projects\Http\Controllers\CategoriesApiController;
use TypiCMS\Modules\Projects\Http\Controllers\PublicController;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define the routes for the application.
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
                            $router->get($uri, $options + ['uses' => [PublicController::class, 'index']])->name($lang.'::index-projects');
                            $router->get($uri.'/{category}', $options + ['uses' => [PublicController::class, 'indexOfCategory']])->name($lang.'::projects-category');
                            $router->get($uri.'/{category}/{slug}', $options + ['uses' => [PublicController::class, 'show']])->name($lang.'::project');
                        }
                    }
                });
            }

            /*
             * Admin routes
             */
            $router->middleware('admin')->prefix('admin')->group(function (Router $router) {
                $router->get('projects', [AdminController::class, 'index'])->name('admin::index-projects')->middleware('can:read projects');
                $router->get('projects/create', [AdminController::class, 'create'])->name('admin::create-project')->middleware('can:create projects');
                $router->get('projects/{project}/edit', [AdminController::class, 'edit'])->name('admin::edit-project')->middleware('can:update projects');
                $router->get('projects/{project}/files', [AdminController::class, 'files'])->name('admin::edit-project-files')->middleware('can:update projects');
                $router->post('projects', [AdminController::class, 'store'])->name('admin::store-project')->middleware('can:create projects');
                $router->put('projects/{project}', [AdminController::class, 'update'])->name('admin::update-project')->middleware('can:update projects');

                $router->get('projects/categories', [CategoriesAdminController::class, 'index'])->name('admin::index-project_categories')->middleware('can:read project_categories');
                $router->get('projects/categories/create', [CategoriesAdminController::class, 'create'])->name('admin::create-project_category')->middleware('can:create project_categories');
                $router->get('projects/categories/{category}/edit', [CategoriesAdminController::class, 'edit'])->name('admin::edit-project_category')->middleware('can:update project_categories');
                $router->post('projects/categories', [CategoriesAdminController::class, 'store'])->name('admin::store-project_category')->middleware('can:create project_categories');
                $router->put('projects/categories/{category}', [CategoriesAdminController::class, 'update'])->name('admin::update-project_category')->middleware('can:update project_categories');
            });

            /*
             * API routes
             */
            $router->middleware('api')->prefix('api')->group(function (Router $router) {
                $router->middleware('auth:api')->group(function (Router $router) {
                    $router->get('projects', [ApiController::class, 'index'])->middleware('can:read projects');
                    $router->patch('projects/{project}', [ApiController::class, 'updatePartial'])->middleware('can:update projects');
                    $router->delete('projects/{project}', [ApiController::class, 'destroy'])->middleware('can:delete projects');
                    $router->get('projects/categories', [CategoriesApiController::class, 'index'])->middleware('can:read project_categories');
                    $router->patch('projects/categories/{category}', [CategoriesApiController::class, 'updatePartial'])->middleware('can:update project_categories');
                    $router->post('projects/categories/sort', [CategoriesApiController::class, 'sort'])->middleware('can:update project_categories');
                    $router->delete('projects/categories/{category}', [CategoriesApiController::class, 'destroy'])->middleware('can:delete project_categories');
                });
            });
        });
    }
}
