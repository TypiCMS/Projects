<li class="project-list-item">
    <a class="project-list-item-link" href="{{ $project->uri() }}">
        @empty(! $project->image)
            <img class="project-list-item-image" src="{{ $project->present()->image(600, 400) }}" width="300" height="200" alt="{{ $project->image->alt_attribute }}" />
        @endempty

        <div class="project-list-item-info">
            <div class="project-list-item-title">{{ $project->title }}</div>
            @empty(! $project->summary)
                <div class="project-list-item-summary">{{ $project->summary }}</div>
            @endempty

            <div class="project-list-item-date">{{ $project->present()->dateLocalized }}</div>
        </div>
    </a>
</li>
