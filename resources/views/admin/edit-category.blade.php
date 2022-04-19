@extends('core::admin.master')

@section('title', $model->present()->title)

@section('content')

    {!! BootForm::open()->put()->action(route('admin::update-project_category', $model->id))->multipart()->role('form') !!}
    {!! BootForm::bind($model) !!}
        @include('projects::admin._form-category')
    {!! BootForm::close() !!}

@endsection
