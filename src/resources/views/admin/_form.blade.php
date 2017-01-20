@section('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
@endsection

@include('core::admin._buttons-form')

{!! BootForm::hidden('id') !!}

@include('core::admin._image-fieldset', ['field' => 'image'])

@include('core::form._title-and-slug')
{!! TranslatableBootForm::hidden('status')->value(0) !!}
{!! TranslatableBootForm::checkbox(__('validation.attributes.online'), 'status') !!}

@include('core::admin._galleries-fieldset')

{!! BootForm::select(__('validation.attributes.category_id'), 'category_id', Categories::allForSelect()) !!}
{!! BootForm::text(__('validation.attributes.tags'), 'tags')->value(old('tags') ? : implode(', ', $model->tags->pluck('tag')->all())) !!}
<div class="row">
    <div class="col-sm-6">
        {!! BootForm::date(__('validation.attributes.date'), 'date')->value(old('date') ? : $model->present()->dateOrNow('date'))->addClass('datepicker') !!}
    </div>
</div>
{!! BootForm::text(__('validation.attributes.website'), 'website')->placeholder('http://') !!}

{!! TranslatableBootForm::textarea(__('validation.attributes.summary'), 'summary')->rows(4) !!}
{!! TranslatableBootForm::textarea(__('validation.attributes.body'), 'body')->addClass('ckeditor') !!}
