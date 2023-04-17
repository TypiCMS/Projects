<ul class="project-list-results-list">
    @foreach ($items as $project)
        <li class="project-list-results-item">
            <a class="project-list-results-item-link" href="{{ $project->uri() }}">
                <span class="project-list-results-item-title">{{ $project->title }}</span>
                <span class="project-list-results-item-date">{{ $project->present()->dateLocalized }}</span>
            </a>
        </li>
    @endforeach
</ul>
