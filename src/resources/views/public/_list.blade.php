<ul class="projects-list">
    @foreach ($items as $project)
    @include('projects::public._list-item')
    @endforeach
</ul>
