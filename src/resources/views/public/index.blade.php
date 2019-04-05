@extends('pages::public.master')

@section('bodyClass', 'body-projects body-projects-categories body-page body-page-'.$page->id)

@section('content')

    {!! $page->present()->body !!}

    @include('files::public._documents', ['model' => $page])
    @include('files::public._images', ['model' => $page])

    @if ($categories->count() > 0)

        <ul class="category-list-list">
            @foreach ($categories as $category)
            <li class="category-list-item">
                <a class="category-list-item-link" href="{{ route($lang.'::projects-category', [$category->slug]) }}">
                    <div class="category-list-item-title">{{ $category->title }}</div>
                    <div class="category-list-item-image-wrapper">
                        <img class="category-list-item-image" src="{!! $category->present()->image(270, 270) !!}" alt="">
                    </div>
                </a>
            </li>
            @endforeach
        </ul>

    @endif

@endsection
