@extends('core::admin.master')

@section('title', __('New project'))

@section('content')

    {!! BootForm::open()->action(route('admin::index-projects'))->multipart()->role('form') !!}
        @include('projects::admin._form')
    {!! BootForm::close() !!}

@endsection
