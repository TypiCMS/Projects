@extends('core::admin.master')

@section('title', trans('projects::global.name'))

@section('main')

<div id="table">

    <script>
    var columns = ['id', 'status', 'thumb', 'date', 'title', 'category_name'];
    var options = {
        sortable: ['status', 'date', 'title', 'category_name'],
        headings: {},
        orderBy: {
            column: 'date',
            ascending: false
        }
    };
    </script>

    @include('core::admin._table-config')

    @include('core::admin._button-create', ['module' => 'projects'])

    <h1>@lang('projects::global.name')</h1>

    <div class="btn-toolbar">
        @include('core::admin._lang-switcher')
    </div>

    <div class="table-responsive">
        @include('core::admin._v-client-table', ['data' => Projects::allFiltered(config('typicms.projects.select'), ['category'])])
        {{-- For server side filtering, use @include('core::admin._v-server-table', ['url' => route('api::index-projects')]) --}}
    </div>

</div>

@endsection
