@extends('core::admin.master')

@section('title', $model->present()->title)

@section('content')

    <div class="header">
        @include('core::admin._button-back', ['module' => 'projects'])
        <h1 class="header-title @empty($model->title)text-muted @endempty">
            {{ $model->present()->title ?: __('Untitled') }}
        </h1>
    </div>

    {!! BootForm::open()->put()->action(route('admin::update-project', $model->id))->multipart()->role('form') !!}
    {!! BootForm::bind($model) !!}
        @include('projects::admin._form')
    {!! BootForm::close() !!}

@endsection
