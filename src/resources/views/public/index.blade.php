@extends('pages::public.master')

@section('bodyClass', 'body-projects body-projects-categories body-page body-page-'.$page->id)

@section('content')

    {!! $page->present()->body !!}

    @include('files::public._documents', ['model' => $page])
    @include('files::public._images', ['model' => $page])

    @if ($categories->count() > 0)

        <ul class="categories-list">
            @foreach ($categories as $category)
            <li class="categories-item">
                <a class="categories-item-link" href="{{ route($lang.'::projects-category', [$category->slug]) }}">
                    <div class="categories-item-title">{{ $category->title }}</div>
                    <div class="categories-item-image">{!! $category->present()->thumb(270, 270) !!}</div>
                </a>
            </li>
            @endforeach
        </ul>

    @endif

@endsection
