@extends('manage::frontendPagesPreview')

@section('content')
    {{--<div class="previewlivesettingifream" style="background: white;">--}}
        {{--<div class="normal">{!! (isset($data['layout'])?BBRenderPageSections($data['layout'],$data['settings']): BBRenderPageBody($data['page']->slug,$data['settings'])) !!}</div>--}}
    {{--</div>--}}
    {{--<div id="previewImageifreamimage"></div>--}}

    {!! Sahakavatar\Cms\Models\ContentLayouts\ContentLayouts::getPageLayoutPlaceholders($data['page'],true) !!}

    <div class="modal fade" id="area-settings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="checkboxes">Area access</label>
                        <div class="col-md-4">
                            @php
                                $frontendRoles=new \Sahakavatar\User\Repository\RoleRepository();
                            @endphp
                            @foreach($frontendRoles->getFrontRoles() as $role)
                                <div class="checkbox">
                                    <label for="checkboxes-1">
                                        {!! Form::checkbox('page_layout_settings[sidebar_left_roles][]',$role->slug,(isset($page->page_layout_settings['sidebar_left_roles']) && in_array($role->slug,$page->page_layout_settings['sidebar_left_roles']))?1:0) !!}
                                        {!! $role->name !!}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--{!! Form::close() !!}--}}
    </div>

@stop

@section('CSS')
    {!! HTML::style('css/create_pages.css') !!}
    {!! HTML::style('css/preview-template.css') !!}
    {!! HTML::style("/css/preview-template.css") !!}
    <style>
        .main-wrapper {
            height: 100vh;
            background: white;
        }
        .section {
            height: 100%;
            display: grid;
        }
    </style>
@stop

@section('JS')
    {!! HTML::script("js/html2canvas/js/html2canvas.js") !!}
    {!! HTML::script("js/canvas2image/js/canvas2image.js") !!}
    {!! HTML::script("js/bootbox/js/bootbox.min.js") !!}
    {!! HTML::script("js/UiElements/ui-page-preview-setting.js") !!}
    {!! HTML::script('/js/tinymice/tinymce.min.js') !!}

    <script>
        $(document).ready(function () {
            $("body").on("click",'.area-settings',function () {
                $("#area-settings").modal();
            });

            $("body").on("click",'.area-css',function () {
                $("#area-css").modal();
            });


            tinymce.init({
                selector: '.main_content_editor', // change this value according to your HTML
                height: 200,
                theme: 'modern',
                plugins: [
                    'advlist anchor autolink autoresize autosave bbcode charmap code codesample colorpicker contextmenu directionality emoticons fullpage fullscreen hr image imagetools importcss insertdatetime legacyoutput link lists media nonbreaking noneditable pagebreak paste preview print save searchreplace spellchecker tabfocus table template textcolor textpattern visualblocks visualchars wordcount shortcodes',
                ],
                toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help shortcodes',
                image_advtab: true
            });

            $('body').on('change', '.content_type', function () {
                var value = $(this).val();
                var data_area = $(this).data('area');
                if (value == 'editor') {
//                    $('.' + data_area + '_' + value).removeClass('show').addClass('hide');
                    $('.' + data_area + '_' + value).removeClass('hide').addClass('show');
                } else {
//                    $('.editor-page-content').removeClass('show').addClass('hide');
                    $('.' + data_area + '_editor').removeClass('show').addClass('hide');
                }

            });

            var dd=console.log;
            $('body').on('click', '.item', function () {
                var datasetting = $('[datas-settingjson]').val();
                var pagelsod = $(this).find('input').attr('data-action');
                if (pagelsod == "page_sections") {
                    if ($(this).hasClass('m-item')) {
                        var mw = $(this).data('value');
                        if (mw) {
                            var currentUrl = window.location.pathname;
                            var pl = findGetParameter('pl');
                            if (pl) {
                                var url = currentUrl + "?mw=" + mw + "&pl=" + pl + '&pl_live_settings=page_live';
                            } else {
                                var url = currentUrl + "?mw=" + mw + '&pl_live_settings=page_live';
                            }
							window.location.href = url
                        }
                    } else {
                        var layoutID = $(this).data('value');
                        if (layoutID) {
                            var currentUrl = window.location.pathname;
                            var mw = findGetParameter('mw');
                            if (mw) {
                                var url = currentUrl + "?mw=" + mw + "&pl=" + layoutID + '&pl_live_settings=page_live';
                            } else {
                                var url = currentUrl + "?pl=" + layoutID + '&pl_live_settings=page_live';
                            }
							window.location.href = url;
                        }
                    }
                }

            });

            function findGetParameter(parameterName) {
                var result = null,
                    tmp = [];
                location.search
                    .substr(1)
                    .split("&")
                    .forEach(function (item) {
                        tmp = item.split("=");
                        if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
                    });
                return result;
            }

        });
    </script>
@stop