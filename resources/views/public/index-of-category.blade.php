@extends('pages::public.master')

@section('title', $category->title . ' – ' . __('Projects') . ' – ' . $websiteTitle)
@section('ogTitle', $category->title)
@section('ogImage', $category->present()->ogImage())
@section('bodyClass', 'body-projects body-projects-index body-page body-page-' . $page->id)

@section('page')
    <div class="page-body">
        <div class="page-body-container">
            @include('pages::public._main-content', ['page' => $page])
            @include('files::public._document-list', ['model' => $page])
            @include('files::public._image-list', ['model' => $page])

            @includeWhen($models->count() > 0, 'projects::public._list', ['items' => $models])
        </div>
    </div>
@endsection
