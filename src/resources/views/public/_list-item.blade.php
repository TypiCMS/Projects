<li class="project">
    <a class="project-anchor" href="{{ route($lang.'.projects.categories.slug', [$project->category->slug, $project->slug]) }}">
        {!! $project->present()->thumb(540, 400) !!}
        <div class="project-info">
            <div class="project-title">{{ $project->title }}</div>
            <div class="project-summary">{{ $project->summary }}</div>
            <div class="project-date">{{ $project->present()->dateLocalized }}</div>
        </div>
    </a>
</li>
