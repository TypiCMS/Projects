@extends('core::admin.master')

@section('title', __('New project'))

@section('content')

    @include('core::admin._button-back', ['module' => 'projects'])
    <h1>
        @lang('New project')
    </h1>

    {!! BootForm::open()->action(route('admin::index-projects'))->multipart()->role('form') !!}
        @include('projects::admin._form')
    {!! BootForm::close() !!}

@endsection
