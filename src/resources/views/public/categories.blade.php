@extends('pages::public.master')

@section('bodyClass', 'body-projects body-projects-categories body-page body-page-' . $page->id)

@section('main')

    {!! $page->present()->body !!}

    @include('galleries::public._galleries', ['model' => $page])

    @if ($categories->count())

        <ul class="list-categories">
            @foreach ($categories as $category)
            <li>
                <a href="{{ route($lang.'.projects.category', [$category->slug]) }}">
                    <span class="title">{{ $category->title }}</span>
                    {!! $category->present()->thumb(270, 270) !!}
                </a>
            </li>
            @endforeach
        </ul>

    @endif

@stop
