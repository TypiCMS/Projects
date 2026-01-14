<div class="header">
    <x-core::back-button :url="$model->indexUrl()" :title="__('Categories')" />
    <x-core::title :$model :default="__('New project category')" />
    <x-core::form-buttons :$model />
</div>

<div class="content">
    <x-core::form-errors />

    <file-manager></file-manager>
    <file-field type="image" field="image_id" :init-file="{{ $model->image ?? 'null' }}"></file-field>
    <file-field type="image" field="og_image_id" :init-file="{{ $model->ogImage ?? 'null' }}" label="Open Graph image"></file-field>

    <x-core::title-and-slug-fields />
    <div class="mb-3">
        {!! TranslatableBootForm::hidden('status')->value(0) !!}
        {!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}
    </div>
</div>
