@section('js')
    {{ HTML::script(asset('//tinymce.cachefly.net/4.1/tinymce.min.js')) }}
    {{ HTML::script(asset('js/admin/form.js')) }}
@stop

@section('otherSideLink')
    @include('core::admin._navbar-public-link')
@stop


@include('core::admin._buttons-form')

{{ BootForm::hidden('id'); }}

@include('core::admin._image-fieldset', ['field' => 'image'])

<div class="row">
    <div class="col-sm-4 form-group @if($errors->has('category_id'))has-error @endif">
        {{ Form::label('category_id', trans('validation.attributes.category_id'), array('class' => 'control-label')) }}
        {{ Form::select('category_id', Categories::getAllForSelect(), null, array('class' => 'form-control')) }}
        {{ $errors->first('category_id', '<p class="help-block">:message</p>') }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('tags', trans('validation.attributes.tags'), array('class' => 'control-label')) }}
    {{ Form::text('tags', $tags, array('id' => 'tags', 'class' => 'form-control')) }}
</div>

@include('core::admin._tabs-lang')

<div class="tab-content">

    @foreach ($locales as $lang)

    <div class="tab-pane fade @if ($locale == $lang)in active @endif" id="{{ $lang }}">

        <div class="row">
            <div class="col-md-6 form-group">
                {{ BootForm::text(trans('labels.title'), $lang.'[title]') }}
            </div>
            <div class="col-md-6 form-group @if($errors->has($lang.'.slug'))has-error @endif">
                {{ Form::label($lang.'[slug]', trans('validation.attributes.slug'), array('class' => 'control-label')) }}
                <div class="input-group">
                    {{ Form::text($lang.'[slug]', $model->translate($lang)->slug, array('class' => 'form-control')) }}
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-slug @if($errors->has($lang.'.slug'))btn-danger @endif" type="button">@lang('validation.attributes.generate')</button>
                    </span>
                </div>
                {{ $errors->first($lang.'.slug', '<p class="help-block">:message</p>') }}
            </div>
        </div>

        {{ BootForm::checkbox(trans('labels.online'), $lang.'[status]') }}
        {{ BootForm::textarea(trans('labels.summary'), $lang.'[summary]')->addClass('editor')->rows(4) }}
        {{ BootForm::textarea(trans('labels.body'), $lang.'[body]')->addClass('editor') }}
    </div>

    @endforeach

</div>
