@extends('core::admin.master')

@section('title', __('New project category'))

@section('content')

    <div class="header">
        @include('core::admin._button-back', ['module' => 'project_categories'])
        <h1 class="header-title">@lang('New project category')</h1>
    </div>

    {!! BootForm::open()->action(route('admin::index-project_categories'))->multipart()->role('form') !!}
        @include('projects::admin._form-category')
    {!! BootForm::close() !!}

@endsection
