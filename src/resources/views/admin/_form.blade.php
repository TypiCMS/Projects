@section('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/admin/form.js') }}"></script>
@stop

@include('core::admin._buttons-form')

{!! BootForm::hidden('id') !!}

@include('core::admin._image-fieldset', ['field' => 'image'])

@include('core::admin._galleries-fieldset')

{!! BootForm::select(trans('validation.attributes.category_id'), 'category_id', Categories::allForSelect()) !!}
{!! BootForm::text(trans('validation.attributes.tags'), 'tags')->value(implode(', ', $model->tags->lists('tag'))) !!}
<div class="row">
    <div class="col-sm-6">
        {!! BootForm::date(trans('validation.attributes.date'), 'date')->value($model->present()->dateOrNow('date'))->addClass('datepicker') !!}
    </div>
</div>
{!! BootForm::text(trans('validation.attributes.website'), 'website')->placeholder('http://') !!}

@include('core::admin._tabs-lang')

<div class="tab-content">

    @foreach ($locales as $lang)

    <div class="tab-pane fade @if ($locale == $lang)in active @endif" id="{{ $lang }}">
        @include('core::form._title-and-slug')
        <input type="hidden" name="{{ $lang }}[status]" value="0">
        {!! BootForm::checkbox(trans('validation.attributes.online'), $lang.'[status]') !!}
        {!! BootForm::textarea(trans('validation.attributes.summary'), $lang.'[summary]')->rows(4) !!}
        {!! BootForm::textarea(trans('validation.attributes.body'), $lang.'[body]')->addClass('ckeditor') !!}
    </div>

    @endforeach

</div>
