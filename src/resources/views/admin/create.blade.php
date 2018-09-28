@extends('core::admin.master')

@section('title', __('New project'))

@section('content')

    <div class="header">
        @include('core::admin._button-back', ['module' => 'projects'])
        <h1 class="header-title">@lang('New project')</h1>
    </div>

    {!! BootForm::open()->action(route('admin::index-projects'))->multipart()->role('form') !!}
        @include('projects::admin._form')
    {!! BootForm::close() !!}

@endsection
