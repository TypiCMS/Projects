@extends('core::admin.master')

@section('title', __('Project categories'))

@section('content')
    <item-list url-base="/api/projects/categories" fields="id,image_id,position,status,title" table="project_categories" title="categories" include="image" :searchable="['title']" :sorting="['position']">
        <template #back-button>
            <x-core::back-button :url="route('admin::index-projects')" :title="__('Projects')" />
        </template>

        <template #top-buttons v-if="$can('create project_categories')">
            <x-core::create-button :url="route('admin::create-project_category')" :label="__('Create category')" />
        </template>

        <template #columns="{ sortArray }">
            <item-list-column-header name="checkbox" v-if="$can('update project_categories')||$can('delete project_categories')"></item-list-column-header>
            <item-list-column-header name="edit" v-if="$can('update project_categories')"></item-list-column-header>
            <item-list-column-header name="status_translated" sortable :sort-array="sortArray" :label="$t('Status')"></item-list-column-header>
            <item-list-column-header name="position" sortable :sort-array="sortArray" :label="$t('Position')"></item-list-column-header>
            <item-list-column-header name="image" :label="$t('Image')"></item-list-column-header>
            <item-list-column-header name="title_translated" sortable :sort-array="sortArray" :label="$t('Title')"></item-list-column-header>
        </template>

        <template #table-row="{ model, checkedModels, loading }">
            <td class="checkbox" v-if="$can('update project_categories')||$can('delete project_categories')">
                <item-list-checkbox :model="model" :checked-models-prop="checkedModels" :loading="loading"></item-list-checkbox>
            </td>
            <td v-if="$can('update project_categories')">
                <item-list-edit-button :url="'/admin/projects/categories/' + model.id + '/edit'"></item-list-edit-button>
            </td>
            <td>
                <item-list-status-button :model="model"></item-list-status-button>
            </td>
            <td>
                <item-list-position-input :model="model"></item-list-position-input>
            </td>
            <td><img :src="model.thumb" alt="" height="27" /></td>
            <td v-html="model.title_translated"></td>
        </template>
    </item-list>
@endsection
