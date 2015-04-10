<li>
    <a href="{{ route($lang . '.news.slug', $news->slug) }}">
        {!! $news->present()->thumb(540, 400) !!}
        <div class="list-news-info">
            <div class="title">{{ $news->title }}</div>
            <div class="summary">{{ $news->summary }}</div>
            <div class="date">{{ $news->present()->dateLocalized }}</div>
        </div>
    </a>
</li>
