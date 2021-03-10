<ul class="project-list-list">
    @foreach ($items as $project)
    @include('projects::public._list-item')
    @endforeach
</ul>
