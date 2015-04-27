@extends('pages::public.master')
<?php $page = TypiCMS::getPageLinkedToModule('projects') ?>

@section('bodyClass', 'body-projects body-projects-index body-page body-page-' . $page->id)

@section('main')

    {!! $page->body !!}

    @include('galleries::public._galleries', ['model' => $page])

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
