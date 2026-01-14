<div class="header">
    <x-core::back-button :url="$model->indexUrl()" :title="__('Projects')" />
    <x-core::title :$model :default="__('New project')" />
    <x-core::form-buttons :$model />
</div>

<div class="content">
    <x-core::form-errors />

    <div class="row">
        <div class="col-lg-8">
            <x-core::title-and-slug-fields />
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
        <div class="col-lg-4">
            <div class="right-column">
                <file-manager></file-manager>
                <file-field type="image" field="image_id" :init-file="{{ $model->image ?? 'null' }}"></file-field>
                <file-field type="image" field="og_image_id" :init-file="{{ $model->ogImage ?? 'null' }}" label="Open Graph image"></file-field>
                <files-field :init-files="{{ $model->files }}"></files-field>
            </div>
        </div>
    </div>
</div>
