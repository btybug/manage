@extends('btybug::layouts.frontend')
@section('content')
    <div class="col-md-12 m-15">
        <button class="btn btn-info pull-right" data-settingaction="setting"> Setting</button>
        <button class="btn btn-success pull-right" data-settingaction="save"> save</button>
    </div>
    <div class="col-md-12">
        <div id="widget_container" class="col-md-9">
            {!! $html !!}
        </div>
        <div id="output-content" class="col-md-3">
            {!! Form::model($model,['url' => '/admin/manage/gears', 'id'=>'add_custome_page']) !!}
            {!! $settingsHtml !!}
            {!! Form::close() !!}
        </div>
    </div>
@stop

<div>
    <div class="withoutifreamsetting animated bounceInRight hide" data-settinglive="settings">

    </div>
    <div class="modal fade" id="magic-settings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        {{--{!! Form::open(['url'=>'/admin/backend/theme-edit/live-save', 'id'=>'magic-form']) !!}--}}
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    {{--{!! Form::submit('Save',['class' => 'btn btn-success pull-right m-r-10']) !!}--}}
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body" style="min-height: 500px;">

                    <div id="magic-body">

                    </div>
                </div>
            </div>
        </div>
        {{--{!! Form::close() !!}--}}
    </div>


    @include('resources::assests.magicModal')

</div>
@section('CSS')
    <style>
        .m-15 {margin: 15px;}
    </style>
    {!! HTML::style("https://jqueryvalidation.org/files/demo/site-demos.css") !!}
    {!! HTML::style('js/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') !!}
    {!! HTML::style('/css/preview-template.css') !!}
    {!! HTML::style("/js/animate/css/animate.css") !!}
    {!! HTML::style("/css/preview-template.css") !!}
    @yield('CSS')
    @stack('css')
@stop
@section('JS')
    {!! HTML::script("js/bootstrap.min.js") !!}
    {!! HTML::script("/js/UiElements/ui-preview-setting.js") !!}
    {!! HTML::script("/js/UiElements/ui-settings.js") !!}
    {!! HTML::script("js/UiElements/bb_styles.js") !!}
    {!! HTML::script("js/UiElements/bb_div.js") !!}
    {!! HTML::script("js/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js") !!}
    {!! HTML::script("https://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js") !!}
    {!! HTML::script("https://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js") !!}
    {!! HTML::script("js/tinymice/tinymce.min.js") !!}
    {!! HTML::script('js/UiElements/content-layout-settings.js') !!}

    {!! HTML::script("/js/UiElements/bb_div.js") !!}

    @yield('JS')
    @stack('javascript')
@stop
