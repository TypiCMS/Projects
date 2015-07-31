<li>
    <a href="{{ route($lang.'.projects.categories.slug', [$project->category->slug, $project->slug]) }}">
        {!! $project->present()->thumb(540, 400) !!}
        <div class="list-projects-info">
            <div class="title">{{ $project->title }}</div>
            <div class="summary">{{ $project->summary }}</div>
            <div class="date">{{ $project->present()->dateLocalized }}</div>
        </div>
    </a>
</li>
