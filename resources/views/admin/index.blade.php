@extends('core::admin.master')

@section('title', __('Projects'))

@section('content')
    <item-list url-base="/api/projects" fields="id,image_id,category_id,date,status,title" table="projects" title="projects" include="image" :exportable="true" :searchable="['title']"
        :sorting="['-date']">
        <template slot="add-button">
            <span v-if="$can('create projects')">
                @include('core::admin._button-create', ['url' => route('admin::create-project')])
            </span>
            <a href="{{ route('admin::index-project_categories') }}" class="btn btn-sm btn-secondary" v-if="$can('read project_categories')">
                @lang('Categories')
            </a>
        </template>

        <template slot="columns" slot-scope="{ sortArray }">
            <item-list-column-header name="checkbox" v-if="$can('update projects')||$can('delete projects')"></item-list-column-header>
            <item-list-column-header name="edit" v-if="$can('update projects')"></item-list-column-header>
            <item-list-column-header name="status_translated" sortable :sort-array="sortArray" :label="$t('Status')"></item-list-column-header>
            <item-list-column-header name="image" :label="$t('Image')"></item-list-column-header>
            <item-list-column-header name="date" sortable :sort-array="sortArray" :label="$t('Date')"></item-list-column-header>
            <item-list-column-header name="category_name" sortable :sort-array="sortArray" :label="$t('Category')"></item-list-column-header>
            <item-list-column-header name="title_translated" sortable :sort-array="sortArray" :label="$t('Title')"></item-list-column-header>
        </template>

        <template slot="table-row" slot-scope="{ model, checkedModels, loading }">
            <td class="checkbox" v-if="$can('update projects')||$can('delete projects')">
                <item-list-checkbox :model="model" :checked-models-prop="checkedModels" :loading="loading"></item-list-checkbox>
            </td>
            <td v-if="$can('update projects')">
                <item-list-edit-button :url="'/admin/projects/' + model.id + '/edit'"></item-list-edit-button>
            </td>
            <td>
                <item-list-status-button :model="model"></item-list-status-button>
            </td>
            <td><img :src="model.thumb" alt="" height="27" /></td>
            <td>@{{ model.date | date }}</td>
            <td>@{{ model.category_name }}</td>
            <td v-html="model.title_translated"></td>
        </template>
    </item-list>
@endsection
