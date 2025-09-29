<?php

use TypiCMS\Modules\Core\Models\Page;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Projects\Http\Controllers\AdminController;
use TypiCMS\Modules\Projects\Http\Controllers\ApiController;
use TypiCMS\Modules\Projects\Http\Controllers\CategoriesAdminController;
use TypiCMS\Modules\Projects\Http\Controllers\CategoriesApiController;
use TypiCMS\Modules\Projects\Http\Controllers\PublicController;

/*
 * Front office routes
 */
if (($page = getPageLinkedToModule('projects')) instanceof Page) {
    $middleware = $page->private ? ['public', 'auth'] : ['public'];
    foreach (locales() as $lang) {
        if ($page->isPublished($lang) && $path = $page->path($lang)) {
            Route::middleware($middleware)->prefix($path)->name($lang . '::')->group(function (Router $router): void {
                $router->get('/', [PublicController::class, 'index'])->name('index-projects');
                $router->get('{category}', [PublicController::class, 'indexOfCategory'])->name('projects-category');
                $router->get('{category}/{slug}', [PublicController::class, 'show'])->name('project');
            });
        }
    }
}

/*
 * Admin routes
 */
Route::middleware('admin')->prefix('admin')->name('admin::')->group(function (Router $router): void {
    $router->get('projects', [AdminController::class, 'index'])->name('index-projects')->middleware('can:read projects');
    $router->get('projects/export', [AdminController::class, 'export'])->name('export-projects')->middleware('can:read projects');
    $router->get('projects/create', [AdminController::class, 'create'])->name('create-project')->middleware('can:create projects');
    $router->get('projects/{project}/edit', [AdminController::class, 'edit'])->name('edit-project')->middleware('can:read projects');
    $router->get('projects/{project}/files', [AdminController::class, 'files'])->name('edit-project-files')->middleware('can:update projects');
    $router->post('projects', [AdminController::class, 'store'])->name('store-project')->middleware('can:create projects');
    $router->put('projects/{project}', [AdminController::class, 'update'])->name('update-project')->middleware('can:update projects');

    $router->get('projects/categories', [CategoriesAdminController::class, 'index'])->name('index-project_categories')->middleware('can:read project_categories');
    $router->get('projects/categories/create', [CategoriesAdminController::class, 'create'])->name('create-project_category')->middleware('can:create project_categories');
    $router->get('projects/categories/{category}/edit', [CategoriesAdminController::class, 'edit'])->name('edit-project_category')->middleware('can:read project_categories');
    $router->post('projects/categories', [CategoriesAdminController::class, 'store'])->name('store-project_category')->middleware('can:create project_categories');
    $router->put('projects/categories/{category}', [CategoriesAdminController::class, 'update'])->name('update-project_category')->middleware('can:update project_categories');
});

/*
 * API routes
 */
Route::middleware(['api', 'auth:api'])->prefix('api')->group(function (Router $router): void {
    $router->get('projects', [ApiController::class, 'index'])->middleware('can:read projects');
    $router->patch('projects/{project}', [ApiController::class, 'updatePartial'])->middleware('can:update projects');
    $router->delete('projects/{project}', [ApiController::class, 'destroy'])->middleware('can:delete projects');
    $router->get('projects/categories', [CategoriesApiController::class, 'index'])->middleware('can:read project_categories');
    $router->patch('projects/categories/{category}', [CategoriesApiController::class, 'updatePartial'])->middleware('can:update project_categories');
    $router->post('projects/categories/sort', [CategoriesApiController::class, 'sort'])->middleware('can:update project_categories');
    $router->delete('projects/categories/{category}', [CategoriesApiController::class, 'destroy'])->middleware('can:delete project_categories');
});
