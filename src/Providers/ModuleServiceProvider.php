<?php

namespace TypiCMS\Modules\Projects\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Models\Tag;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Core\Observers\TipTapHTMLObserver;
use TypiCMS\Modules\Projects\Composers\SidebarViewComposer;
use TypiCMS\Modules\Projects\Facades\ProjectCategories;
use TypiCMS\Modules\Projects\Facades\Projects;
use TypiCMS\Modules\Projects\Models\Project;
use TypiCMS\Modules\Projects\Models\ProjectCategory;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/projects.php', 'typicms.modules.projects');
        $this->mergeConfigFrom(__DIR__ . '/../config/project_categories.php', 'typicms.modules.project_categories');

        $this->loadRoutesFrom(__DIR__ . '/../routes/projects.php');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views/', 'projects');

        $this->publishes([
            __DIR__ . '/../../database/migrations/create_project_categories_table.php.stub' => getMigrationFileName('create_project_categories_table'),
            __DIR__ . '/../../database/migrations/create_projects_table.php.stub' => getMigrationFileName('create_projects_table'),
        ], 'typicms-migrations');
        $this->publishes([__DIR__ . '/../../resources/views' => resource_path('views/vendor/projects')], 'typicms-views');
        $this->publishes([__DIR__ . '/../../resources/scss' => resource_path('scss')], 'typicms-resources');

        AliasLoader::getInstance()->alias('Projects', Projects::class);
        AliasLoader::getInstance()->alias('ProjectCategories', ProjectCategories::class);

        // Observers
        Project::observe(new SlugObserver());
        Project::observe(new TipTapHTMLObserver());
        ProjectCategory::observe(new SlugObserver());

        View::composer('core::admin._sidebar', SidebarViewComposer::class);

        // A project have tags.
        Tag::resolveRelationUsing('projects', function ($tag) {
            return $tag->morphedByMany(Project::class, 'taggable');
        });

        // Add the page in the view.
        View::composer('projects::public.*', function ($view) {
            $view->page = getPageLinkedToModule('projects');
        });
    }

    public function register(): void
    {
        $this->app->bind('Projects', Project::class);
        $this->app->bind('ProjectCategories', ProjectCategory::class);
    }
}
