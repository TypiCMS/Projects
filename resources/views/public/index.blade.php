@extends('pages::public.master')

@section('bodyClass', 'body-projects body-projects-categories body-page body-page-'.$page->id)

@section('page')

<div class="page-body">

    <div class="page-body-container">

        <div class="rich-content">{!! $page->present()->body !!}</div>

        @include('files::public._documents', ['model' => $page])
        @include('files::public._images', ['model' => $page])

        @if ($categories->count() > 0)

            <ul class="category-list-list">
                @foreach ($categories as $category)
                <li class="category-list-item">
                    <a class="category-list-item-link" href="{{ route($lang.'::projects-category', [$category->slug]) }}">
                        <div class="category-list-item-title">{{ $category->title }}</div>
                        @empty(!$category->image)
                        <img class="category-list-item-image" src="{{ $category->present()->image(600, 400) }}" width="300" height="200" alt="{{ $category->image->alt_attribute }}">
                        @endempty
                    </a>
                </li>
                @endforeach
            </ul>

        @endif

    </div>

</div>

@endsection
