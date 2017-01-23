<li class="projects-item">
    <a class="projects-item-anchor" href="{{ route($lang.'::project', [$project->category->slug, $project->slug]) }}">
        {!! $project->present()->thumb(540, 400) !!}
        <div class="projects-item-info">
            <div class="projects-item-title">{{ $project->title }}</div>
            <div class="projects-item-summary">{{ $project->summary }}</div>
            <div class="projects-item-date">{{ $project->present()->dateLocalized }}</div>
        </div>
    </a>
</li>
