@extends('cms::layouts.mTabs',['index'=>'frontend_manage'])
@section('tab')
    <div role="tabpanel" class="m-t-10" id="main">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 main_container_11">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 panels_wrapper settings_panel">
                    <div class="panel panel-default panels accordion_panels" id="my-accordion">
                        <div class="panel-heading bg-black-darker text-white" role="tab" id="headingLinkSettings">
                            <span class="panel_title">General Settings</span>
                            <a role="button" class="panelcollapsed collapsed" data-toggle="collapse"
                               data-parent="#accordion" href="#collapseLink3" aria-expanded="true"
                               aria-controls="collapseLink3">
                                <i class="fa fa-chevron-down" aria-hidden="true"></i>
                            </a>
                            <ul class="list-inline panel-actions">
                                <li><a href="#" panel-fullscreen="true" role="button" title="Toggle fullscreen"><i
                                                class="glyphicon glyphicon-resize-full"></i></a></li>
                            </ul>
                        </div>
                        <div id="collapseLink3" class="panel-collapse collapse in" role="tabpanel"
                             aria-labelledby="headingLinkSettings">
                            <div class="panel-body panel_body panel_1 show">
                                <div>
                                    {!! Form::model($system,['class' => 'form-horizontal','files' => true]) !!}
                                    <fieldset>
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="for_button_1 col-xs-12 col-sm-12 col-md-12 col-lg-9">
                                                        {!! BBbutton2('unit','header_tpl','frontend_header','Select Header',['class' => 'form-control input-md btn-info','data-type' => 'header','model' =>$system]) !!}
                                                    </div>
                                                    <div class="for_button_1 col-xs-6 col-sm-6 col-md-2 col-lg-3">
                                                        <input type="hidden" name="header_enabled" value="0">
                                                        {!! Form::checkbox('header_enabled', 1, null, ['id' => 'page_header_active', ]) !!}
                                                        <label for="page_header_active">Enabled</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="for_button_1 col-xs-12 col-sm-12 col-md-12 col-lg-9">
                                                        {!! BBbutton2('unit','footer_tpl','frontend_footer','Select Footer',['class' => 'form-control input-md btn-info','data-type' => 'footer','model' =>$system]) !!}
                                                    </div>
                                                    <div class="for_button_1 col-xs-6 col-sm-6 col-md-6 col-lg-3">
                                                        <input type="hidden" name="footer_enabled" value="0">
                                                        {!! Form::checkbox('footer_enabled', 1, null, ['id' => 'page_footer_active']) !!}
                                                        <label for="page_footer_active">Enabled</label>
                                                    </div>
                                                </div>

                                                <div class="form-group">

                                                    <div class="for_button_1 col-xs-12 col-sm-12 col-md-12 col-lg-9">
                                                        {!! BBbutton('units','default_field_html','Select Field Html',[
                                                            'class' => 'form-control input-md btn-success',
                                                            "data-type" => 'frontend',
                                                            'data-sub' => "component",
                                                            'model' => $system
                                                        ]) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    {!!Sahakavatar\Cms\Models\ContentLayouts\ContentLayouts::getDefaultLayoutPlaceholders($system) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Button -->
                                        <div class="form-group">
                                            {{--<div class="col-md-12 for_save_btn">--}}
                                            {!! Form::submit('Save',['class' => 'btn btn-primary']) !!}
                                            {{--</div>--}}
                                        </div>
                                    </fieldset>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('resources::assests.magicModal')
@stop
@section('CSS')
    {!! HTML::style('css/menu.css?v=0.16') !!}
    {!! HTML::style('css/admin_pages.css') !!}
    {!! HTML::style('css/tool-css.css?v=0.23') !!}
    {!! HTML::style('css/page.css?v=0.15') !!}

@stop


@section('JS')
    {!! HTML::script("js/UiElements/bb_styles.js?v.5") !!}
    {!! HTML::script('js/admin_pages.js') !!}
    {!! HTML::script('js/nestedSortable/jquery.mjs.nestedSortable.js') !!}
    {!! HTML::script('js/bootbox/js/bootbox.min.js') !!}
    {!! HTML::script('js/icon-plugin.js?v=0.4') !!}
    {!! HTML::script('/js/tinymice/tinymce.min.js') !!}
    {!! HTML::script('/js/page-setting.js') !!}
@stop
