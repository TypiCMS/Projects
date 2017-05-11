@extends('pages::public.master')

@section('bodyClass', 'body-projects body-projects-index body-page body-page-'.$page->id)

@section('content')

    {!! $page->present()->body !!}

    @include('files::public._files', ['model' => $page])

    @if ($models->count())
    @include('projects::public._list', ['items' => $models])
    @endif

@endsection
