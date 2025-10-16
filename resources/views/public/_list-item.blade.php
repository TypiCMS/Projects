<li class="project-list-item">
    <a class="project-list-item-link" href="{{ $project->url() }}">
        <img class="project-list-item-image" src="{{ $project->present()->image(800, 600) }}" width="400" height="300" alt="{{ $project->image?->alt_attribute }}" />
        <div class="project-list-item-info">
            <div class="project-list-item-title">{{ $project->title }}</div>
            @if (!empty($project->summary))
                <div class="project-list-item-summary">{{ $project->summary }}</div>
            @endif

            <div class="project-list-item-date">{{ $project->present()->dateLocalized }}</div>
        </div>
    </a>
</li>
