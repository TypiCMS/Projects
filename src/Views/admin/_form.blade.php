@section('js')
    <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
    <script src="{{ asset('js/admin/form.js') }}"></script>
@stop

@section('otherSideLink')
    @include('core::admin._navbar-public-link')
@stop


@include('core::admin._buttons-form')

{!! BootForm::hidden('id') !!}

@include('core::admin._image-fieldset', ['field' => 'image'])

    {!! BootForm::select(trans('validation.attributes.category_id'), 'category_id', Categories::getAllForSelect()) !!}
    {!! BootForm::text(trans('validation.attributes.tags'), 'tags')->value($tags) !!}

@include('core::admin._tabs-lang')

<div class="tab-content">

    @foreach ($locales as $lang)

    <div class="tab-pane fade @if ($locale == $lang)in active @endif" id="{{ $lang }}">
        @include('core::form._title-and-slug')
        {!! BootForm::checkbox(trans('validation.attributes.online'), $lang.'[status]') !!}
        {!! BootForm::textarea(trans('validation.attributes.summary'), $lang.'[summary]')->addClass('editor')->rows(4) !!}
        {!! BootForm::textarea(trans('validation.attributes.body'), $lang.'[body]')->addClass('editor') !!}
    </div>

    @endforeach

</div>
