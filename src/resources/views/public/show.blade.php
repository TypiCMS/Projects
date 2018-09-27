@extends('core::public.master')

@section('title', $model->title.' – '.__('Projects').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->thumbUrl())
@section('bodyClass', 'body-projects body-project-'.$model->id.' body-page body-page-'.$page->id)

@section('content')

    <div class="btn-group-prev-next">
        <div class="btn-group">
            <a class="btn btn-sm btn-prev btn-light @if (!$prev = Projects::prev($model, $model->category_id))disabled @endif" href="@if ($prev){{ route($lang.'::project', [$prev->category->slug, $prev->slug]) }}@endif">{{ __('Previous') }}</a>
            <a class="btn btn-sm btn-prev btn-light" href="{{ route($lang.'::projects-category', $model->category->slug) }}">{{ $model->category->title }}</a>
            <a class="btn btn-sm btn-next btn-light @if (!$next = Projects::next($model, $model->category_id))disabled @endif" href="@if ($next){{ route($lang.'::project', [$next->category->slug, $next->slug]) }}@endif">{{ __('Next') }}</a>
        </div>
    </div>

    <article class="project">
        <h1 class="project-title">{{ $model->title }}</h1>
        <p class="project-summary">{!! nl2br($model->summary) !!}</p>
        <div class="project-body">{!! $model->present()->body !!}</div>
        @include('files::public._documents')
        @include('files::public._images')
    </article>

@endsection
