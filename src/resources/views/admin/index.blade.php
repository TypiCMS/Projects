@extends('core::admin.master')

@section('title', __('projects::global.name'))

@section('content')

<div ng-app="typicms" ng-cloak ng-controller="ListController">

    @include('core::admin._button-create', ['module' => 'projects'])

    <h1>
        <span>@{{ models.length }} @choice('projects::global.projects', 2)</span>
    </h1>

    <div class="btn-toolbar">
        @include('core::admin._button-select')
        @include('core::admin._button-actions')
        @can('index-project-categories')
        <a class="btn btn-success" href="{{ route('admin::index-project-categories') }}">@lang('projects::global.categories')</a>
        @endcan
        @include('core::admin._lang-switcher-for-list')
    </div>

    <div class="table-responsive">

        <table st-persist="projectsTable" st-table="displayedModels" st-safe-src="models" st-order st-filter class="table table-condensed table-main">
            <thead>
                <tr>
                    <th class="delete"></th>
                    <th class="edit"></th>
                    <th st-sort="status_translated" class="status_translated st-sort">{{ __('Status') }}</th>
                    <th st-sort="image" class="image st-sort">{{ __('Image') }}</th>
                    <th st-sort="date" st-sort-default="reverse" class="date st-sort">{{ __('Date') }}</th>
                    <th st-sort="title_translated" class="title_translated st-sort">{{ __('Title') }}</th>
                    <th st-sort="category_name" class="category st-sort">{{ __('Category') }}</th>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td>
                        <input st-search="date" class="form-control input-sm" placeholder="@lang('Search')…" type="text">
                    </td>
                    <td>
                        <input st-search="title_translated" class="form-control input-sm" placeholder="@lang('Search')…" type="text">
                    </td>
                    <td>
                        <input st-search="category_name" class="form-control input-sm" placeholder="@lang('Search')…" type="text">
                    </td>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="model in displayedModels">
                    <td>
                        <input type="checkbox" checklist-model="checked.models" checklist-value="model">
                    </td>
                    <td>
                        @include('core::admin._button-edit', ['module' => 'projects'])
                    </td>
                    <td typi-btn-status action="toggleStatus(model)" model="model"></td>
                    <td>
                        <img ng-src="@{{ model.thumb }}" alt="">
                    </td>
                    <td>@{{ model.date | dateFromMySQL:'dd/MM/yyyy' }}</td>
                    <td>@{{ model.title_translated }}</td>
                    <td>@{{ model.category_name }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" typi-pagination></td>
                </tr>
            </tfoot>
        </table>

    </div>

</div>

@endsection
