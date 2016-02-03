@extends('core::public.master')

@section('title', $model->title . ' – ' . trans('projects::global.name') . ' – ' . $websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->thumbUrl())
@section('bodyClass', 'body-projects body-project-' . $model->id . ' body-page body-page-' . $page->id)

@section('main')

    <div class="btn-group-prev-next">
        <div class="btn-group">
            <a class="btn btn-sm btn-prev btn-default @if(!$prev = Projects::prev($model, $model->category_id))disabled @endif" href="@if($prev){{ route($lang . '.' . $model->getTable() . '.category.slug', [$prev->category->slug, $prev->slug]) }}@endif">@lang('core::global.Previous')</a>
            <a class="btn btn-sm btn-prev btn-default" href="{{ route($lang . '.' . $model->getTable() . '.categories', $model->category->slug) }}">{{ $model->category->title }}</a>
            <a class="btn btn-sm btn-next btn-default @if(!$next = Projects::next($model, $model->category_id))disabled @endif" href="@if($next){{ route($lang . '.' . $model->getTable() . '.category.slug', [$next->category->slug, $next->slug]) }}@endif">@lang('core::global.Next')</a>
        </div>
    </div>

    <article class="project">
        <h1 class="project-title">{{ $model->title }}</h1>
        <p class="project-summary">{!! nl2br($model->summary) !!}</p>
        <div class="project-body">{!! $model->present()->body !!}</div>
    </article>

@stop
