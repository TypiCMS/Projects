<div class="header">
    @include('core::admin._button-back', ['url' => $model->indexUrl(), 'title' => __('Projects')])
    @include('core::admin._title', ['default' => __('New project')])
    @component('core::admin._buttons-form', ['model' => $model])
    @endcomponent
</div>

<div class="content">
    @include('core::admin._form-errors')

    <file-manager related-table="{{ $model->getTable() }}" :related-id="{{ $model->id ?? 0 }}"></file-manager>
    <file-field type="image" field="image_id" :init-file="{{ $model->image ?? 'null' }}"></file-field>
    <file-field type="image" field="og_image_id" :init-file="{{ $model->ogImage ?? 'null' }}" label="Open Graph image"></file-field>
    <files-field :init-files="{{ $model->files }}"></files-field>

    @include('core::form._title-and-slug')
    <div class="mb-3">
        {!! TranslatableBootForm::hidden('status')->value(0) !!}
        {!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}
    </div>

    {!! BootForm::select(__('Category'), 'category_id', ProjectCategories::allForSelect())->required() !!}

    {!! BootForm::text(__('Tags'), 'tags')->value(old('tags') ?: $model->tags->pluck('tag')->implode(',')) !!}

    <div class="row gx-3 mb-4">
        @include('taxonomies::admin._checkboxes', ['module' => 'projects'])
    </div>

    <div class="row gx-3">
        <div class="col-sm-6">
            {!! BootForm::date(__('Date'), 'date')->value(old('date') ?: $model->present()->dateOrNow('date'))->addClass('datepicker') !!}
        </div>
    </div>
    {!! BootForm::text(__('Website'), 'website')->type('url')->placeholder('https://') !!}

    {!! TranslatableBootForm::textarea(__('Summary'), 'summary')->rows(4) !!}
    <x-core::tiptap-editors :model="$model" name="body" :label="__('Body')" />
</div>
