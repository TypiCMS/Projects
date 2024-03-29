@extends('core::admin.master')

@section('title', __('New project category'))

@section('content')
    {!! BootForm::open()->action(route('admin::index-project_categories'))->multipart()->role('form') !!}
    @include('projects::admin._form-category')
    {!! BootForm::close() !!}
@endsection
