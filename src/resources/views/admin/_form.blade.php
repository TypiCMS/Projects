@section('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
@endsection

@include('core::admin._buttons-form')

{!! BootForm::hidden('id') !!}

@include('core::admin._image-fieldset', ['field' => 'image'])

@include('core::form._title-and-slug')
{!! TranslatableBootForm::hidden('status')->value(0) !!}
{!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}

@include('core::admin._galleries-fieldset')

{!! BootForm::select(__('Category'), 'category_id', ProjectCategories::allForSelect()) !!}
{!! BootForm::text(__('Tags'), 'tags')->value(old('tags') ? : implode(', ', $model->tags->pluck('tag')->all())) !!}
<div class="row">
    <div class="col-sm-6">
        {!! BootForm::date(__('Date'), 'date')->value(old('date') ? : $model->present()->dateOrNow('date'))->addClass('datepicker') !!}
    </div>
</div>
{!! BootForm::text(__('Website'), 'website')->placeholder('http://') !!}

{!! TranslatableBootForm::textarea(__('Summary'), 'summary')->rows(4) !!}
{!! TranslatableBootForm::textarea(__('Body'), 'body')->addClass('ckeditor') !!}
