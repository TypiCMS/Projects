@extends('core::admin.master')

@section('title', trans('projects::global.New'))

@section('main')

    @include('core::admin._button-back', ['module' => 'projects'])
    <h1>
        @lang('projects::global.New')
    </h1>

    {!! BootForm::open()->action(route('admin::index-projects'))->multipart()->role('form') !!}
        @include('projects::admin._form')
    {!! BootForm::close() !!}

@endsection
