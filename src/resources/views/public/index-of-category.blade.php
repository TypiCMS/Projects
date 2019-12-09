@extends('pages::public.master')

@section('bodyClass', 'body-projects body-projects-index body-page body-page-'.$page->id)

@section('content')

    <div class="rich-content">{!! $page->present()->body !!}</div>

    @include('files::public._documents', ['model' => $page])
    @include('files::public._images', ['model' => $page])

    @includeWhen($models->count() > 0, 'projects::public._list', ['items' => $models])

@endsection
