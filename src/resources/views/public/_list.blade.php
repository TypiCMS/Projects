<ul class="list-news">
    @foreach ($items as $news)
    @include('news::public._list-item')
    @endforeach
</ul>
