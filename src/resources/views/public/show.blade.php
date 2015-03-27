@extends('core::public.master')

@section('title', $model->title . ' – ' . trans('news::global.name') . ' – ' . $websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->thumbAbsoluteSrc())
@section('bodyClass', 'body-project body-project-' . $model->id)

@section('main')

    <article>
        <h1>{{ $model->title }}</h1>
        <p class="summary">{{ nl2br($model->summary) }}</p>
        <div class="body">{!! $model->body !!}</div>
    </article>

@stop
