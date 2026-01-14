@extends('core::public.master')

@section('title', $model->title . ' – ' . __('Projects') . ' – ' . $websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('ogImage', $model->present()->ogImage())
@section('bodyClass', 'body-projects body-project-' . $model->id . ' body-page body-page-' . $page->id)

@section('content')
    <article class="project">
        <header class="project-header">
            <div class="project-header-container">
                <div class="project-header-navigator">
                    <div class="items-navigator">
                        <a class="items-navigator-back" href="{{ route($lang . '::projects-category', $model->category->slug) }}">← {{ $model->category->title }}</a>
                        <div class="items-navigator-previous-next">
                            <a class="items-navigator-previous @if (!($prev = Projects::prev($model, $model->category_id))) disabled @endif" href="@if ($prev) {{ route($lang . '::project', [$prev->category->slug, $prev->slug]) }} @endif">
                                ←
                                @lang('Previous')
                            </a>
                            <a class="items-navigator-next @if (!($next = Projects::next($model, $model->category_id))) disabled @endif" href="@if ($next) {{ route($lang . '::project', [$next->category->slug, $next->slug]) }} @endif">
                                @lang('Next')
                                →
                            </a>
                        </div>
                    </div>
                </div>
                <h1 class="project-title">{{ $model->title }}</h1>
                <div class="project-date">{{ $model->present()->dateLocalized }}</div>
            </div>
        </header>
        <div class="project-body">
            @if ($model->summary)
                <p class="project-summary">{!! nl2br($model->summary) !!}</p>
            @endif

            @if ($model->image)
                <figure class="project-picture">
                    <img class="project-picture-image" src="{{ $model->present()->image(2000, 1000) }}" width="{{ $model->image->width }}" height="{{ $model->image->height }}" alt="" />
                    @if ($model->image->description)
                        <figcaption class="project-picture-legend">{{ $model->image->description }}</figcaption>
                    @endif
                </figure>
            @endif

            @if ($model->body)
                <div class="rich-content">{!! $model->present()->body !!}</div>
            @endif

            @include('files::public._document-list')
            @include('files::public._image-list')
        </div>
    </article>
@endsection
