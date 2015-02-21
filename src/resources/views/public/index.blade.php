@extends('core::public.master')

@section('title', trans('projects::global.name') . ' – ' . $websiteTitle)
@section('ogTitle', trans('projects::global.name'))

@section('main')

    <h2>@lang('projects::global.name')</h2>

    @if ($models->count())

    <ul>
        @foreach ($models as $model)
        <li>
            <strong>{{ $model->title }}</strong>
            <br>
            <a href="{{ route($lang.'.projects.categories.slug', array($model->category->slug, $model->slug)) }}">@lang('db.More')</a>
        </li>
        @endforeach
    </ul>

    @endif

@stop
