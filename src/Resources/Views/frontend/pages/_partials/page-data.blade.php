@if($page)
    {!! Form::model($page,['url' => url("/admin/manage/frontend/pages/settings", [$id]), 'id' => 'page_settings_form']) !!}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pull-right">
                <a data-href="{!! url('/admin/manage/frontend/pages/page-test-preview/'.$page->id."?pl_live_settings=page_live&pl=" . $page->page_layout . '&' . $placeholders) !!}"  class="live-preview-btn"  ><i
                            class="fa fa-eye" aria-hidden="true"></i> View
                </a>
                {{ Form::button('<i class="fa fa-check" aria-hidden="true"></i> Save', array('type' => 'submit', 'class' => 'save_btn')) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-9 connected" data-bbsortable="target">
            <div class="panel panel-default custompanel m-t-20">
                <div class="panel-heading"> Main Content</div>

                <div class="panel-body published_1 @if($page->content_type=='template') hide @endif" id="main_content_editor">
                    {!! Form::textarea('main_content',null,['id' => 'main_content']) !!}
                </div>
                <div class="panel-body published_1 @if($page->content_type=='editor') hide @endif" id="main_content_template">
                                {!! BBRenderUnits($page->template) !!}
                </div>

            </div>
            @if($page->type != 'classify' && $page->type != 'tags')
                {!! Sahakavatar\Cms\Models\ContentLayouts\ContentLayouts::getPageLayoutPlaceholders($page) !!}
            @endif
        </div>
        <div class="col-xs-12 col-sm-3 create connected" data-bbsortable="source">
            <div class="panel panel-default custompanel m-t-20">
                <div class="panel-heading">Main Content</div>
                <div class="panel-body">
                    <div class="row">

                        <!-- Multiple Radios -->
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="radios"></label>
                            <div class="col-md-6">
                                <div class="radio">
                                    <label for="radios-0">
                                        {!! Form::radio('content_type','editor',true) !!}
                                        Editor
                                    </label>
                                </div>
                                <div class="radio">
                                    <label for="radios-1">
                                        {!! Form::radio('content_type','template') !!}
                                        Template
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Select Basic -->
                        <div class="form-group page-template">
                            <div class="col-md-8">
                                {!! BBbutton2('unit','template','front_page_content','BBbutton2',['class'=>'btn btn-info col-md-12 page-template',"model"=>$page]) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {!! Form::close() !!}
    @include('resources::assests.magicModal')
@else
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 design_panel">
        <div class="published_1">
            NO Page
        </div>
    </div>
@endif

@section('CSS')
    {!! HTML::style('/css/create_pages.css') !!}
    <style>
        #main-wrapper {
            min-height: 1000px;
            display: inline-block;
        }

        @media (min-width: 1787px) {
            .header_image, .block {
                height: 398px;
            }
        }

        .live-preview-btn {
            background: #499bc7;
            color: #fff;
            width: 96px;
            height: 38px;
            border-radius: 3px;
            padding: 8px;
            font-size: 17px;
            margin-right: 10px;
            box-shadow: 2px 1px 6px #888888;
            cursor: pointer;
        }
    </style>
@stop
@section('JS')
    {!! HTML::script("/js/UiElements/bb_styles.js?v.5") !!}
    {!! HTML::script('/js/page-setting.js') !!}
    {!! HTML::script("/js/UiElements/bb_div.js?v.5") !!}
    {!! HTML::script('/js/tinymice/tinymce.min.js') !!}
    <script>

        $(document).ready(function () {


            tinymce.init({
                selector: '#main_content', // change this value according to your HTML
                height: 200,
                theme: 'modern',
                 plugins: [
						'advlist anchor autolink autoresize autosave bbcode charmap code codesample colorpicker contextmenu directionality emoticons fullpage fullscreen hr image imagetools importcss insertdatetime legacyoutput link lists media nonbreaking noneditable pagebreak paste preview print save searchreplace spellchecker tabfocus table template textcolor textpattern visualblocks visualchars wordcount shortcodes',
					],
				toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  				toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help shortcodes',
                image_advtab: true
            });

            $('body').on('click', '.live-preview-btn', function() {
                if(!$(this).next().hasClass('redirect-type')) {
                    var typeInput = $('<input/>', {
                        type: 'hidden',
                        name: 'redirect_type',
                        value: 'view',
                        class: 'redirect-type'
                    });
                    $(this).after(typeInput);
                    $('#page_settings_form').submit();
                }

            });
        });

    </script>
@stop