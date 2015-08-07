@extends('pages::public.master')
@inject('page', 'typicms.projects.page')

@section('bodyClass', 'body-projects body-projects-index body-page body-page-' . $page->id)

@section('main')

    {!! $page->present()->body !!}

    @include('galleries::public._galleries', ['model' => $page])

    @if ($models->count())
    @include('projects::public._list', ['items' => $models])
    @endif

@stop
