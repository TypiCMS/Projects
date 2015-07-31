<ul class="list-projects">
    @foreach ($items as $project)
    @include('projects::public._list-item')
    @endforeach
</ul>
