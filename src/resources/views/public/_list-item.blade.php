<li class="project-list-item">
    <a class="project-list-item-link" href="{{ $project->uri() }}">
        <img class="project-list-item-image" src="{!! $project->present()->image(540, 400) !!}" alt="">
        <div class="project-list-item-info">
            <div class="project-list-item-title">{{ $project->title }}</div>
            <div class="project-list-item-summary">{{ $project->summary }}</div>
            <div class="project-list-item-date">{{ $project->present()->dateLocalized }}</div>
        </div>
    </a>
</li>
