@extends('cms::layouts.mTabs',['index'=>'frontend_manage'])
@section('tab')
    {!! HTML::style('app/Modules/Uploads/Resources/assets/css/new-store.css') !!}
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 right">
        <article>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <div class="published_1">
                    <a href="javascript:void(0)" class="btn btn-md add-tax"><i class="fa fa-plus"></i> Add New</a>
                </div>
                <div id="styles" class="panel_bd_styles">
                    <ul class="panel-group" role="tablist" aria-multiselectable="true">
                        @if(count($classifiers))
                            @foreach($classifiers as $classifier)
                                <li class="panel panel-default page_col">
                                    @if(isset($_GET['p']) && $_GET['p'] == $classifier->id)
                                        <div class="panel-heading" style="background-color: black;color:white;"
                                             role="tab" id="headingOne">
                                            @else
                                                @if($loop->first == $classifier->id && ! isset($_GET['p']))
                                                    <div class="panel-heading"
                                                         style="background-color: black;color:white;" role="tab"
                                                         id="headingOne">
                                                        @else
                                                            <div class="panel-heading" role="tab" id="headingOne">
                                                                @endif
                                                                @endif

                                                                <h4 class="panel-title">
                                                                    <a href="?p={{ $classifier->id }}"
                                                                       aria-expanded="true" class="link_name">
                                                                        {{ $classifier->title }}
                                                                    </a>
                                                                </h4>
                                                            </div>
                                </li>
                            @endforeach
                        @else
                            <li data-id="'.$item->id.'" class="panel panel-default page_col">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#" aria-expanded="true"
                                           aria-controls="collapseOne" class="link_name collapsed">
                                            No Classify
                                        </a>
                                    </h4>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 buttons">
                @if(isset($model) && $model)
                    {!! Form::model($model) !!}
                    <div class="layout clearfix">
                        @if($model->image)
                            <img src="{!! $model->image !!}" alt="" class="layoutImg" height="175">
                        @else
                            <img src="/app/Modules/Resources/Resources/assets/img/layout-img.jpg" alt=""
                                 class="layoutImg">
                        @endif

                        <div class="layoutData">
                            <div class="layoutCol">
                                <h4>{!! $model->title !!}</h4>
                                <p>{!! $model->description or "no description" !!}</p>
                            </div>

                            <div class='col-md-12'>
                                <div class="right_btns" style="position: absolute;right: 0;top: -23px;">
                                    <a data-id="{{ $model->id }}" class="btn btn-primary edit-taxonomy"
                                       style="display: block;  margin-bottom: 8px;"><i class="fa fa-edit"></i>Edit</a>
                                    <a data-href="{!! url('/admin/manage/frontend/classify/delete') !!}"
                                       data-key="{!! $model->id !!}" data-type="Classify"
                                       class="delete-button btn btn-danger"
                                       style="display: block;    margin-bottom: 8px;"><i class="fa fa-trash"></i>Delete</a>
                                </div>
                            </div>
                            <div class="layoutFooter row">
                                {{--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 ">--}}
                                {{--<span class="textWrap"><a href="{!! @$unit->author_site !!}" class="link"><i>{!! @$unit->author_site !!}</i></a></span>--}}
                                {{--</div>--}}
                                {{--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4  centerText">--}}
                                {{--<span class="iconRefresh"><i class="fa fa-refresh"></i></span> {!! @$unit->version !!}--}}
                                {{--</div>--}}
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 rightText">
                                    <i class="fa fa-user"></i>{!! BBgetDateFormat(@$model->created_at) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 buttons">
                {!! Form::hidden('description',null,['id' => 'tax_description']) !!}
                {!! Form::hidden('image',null,['id' => 'tax_image']) !!}
                {!! Form::hidden('icon',null,['id' => 'tax_icon']) !!}
                {!! Form::hidden('id',null) !!}
                <div class="col-xs-12 col-sm-12 col-md-9  col-lg-9 col-xl-9 create">
                    @if(count($classifiers))
                        <div class="published_1">
                            <a href="javascript:void(0)" data-classifier="{!! $model->id !!}"
                               class="btn btn-md add-term"><i class="fa fa-plus"></i> Add New Option</a>
                        </div>
                        <div class="published_1">
                            <div style="padding:15px;">
                                <ol id="menus-list" class="sortable ui-sortable ui-droppable dvmin-height terms-box">
                                    {{ \Sahakavatar\Manage\Models\Classifier::RecursiveTerms($classifierItems) }}
                                </ol>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    @endif
                </div>
        </article>
    </div>

    <div class="modal fade" id="classify_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Classify</h4>
                </div>
                <div class="modal-body classify_modal_body">

                </div>
            </div>
        </div>
    </div>

    @include('cms::_partials.delete_modal')
    @include('resources::assests.magicModal')
@stop
@section('CSS')
    {!! HTML::style('css/create_pages.css') !!}
    {!! HTML::style('css/menu.css?v=0.16') !!}
    {!! HTML::style('css/tool-css.css?v=0.23') !!}
    {!! HTML::style('css/page.css?v=0.15') !!}
    {!! HTML::style('css/admin_pages.css') !!}
    {!! HTML::style('js/tag-it/css/jquery.tagit.css') !!}
    <style>
        .page_labels {
            overflow: hidden;
            text-overflow: ellipsis;
            margin: 10px 0 2px 15px;
            background: #e8e7e7;
            padding: 4px 13px;
            border: 1px solid #d6d2d2;
            font-size: 15px;
        }
    </style>
@stop
@section('JS')
    {!! HTML::script('js/create_pages.js') !!}
    {!! HTML::script("/resources/assets/js/UiElements/bb_styles.js?v.5") !!}
    {!! HTML::script('js/admin_pages.js') !!}
    {!! HTML::script('js/nestedSortable/jquery.mjs.nestedSortable.js') !!}
    {!! HTML::script('js/bootbox/js/bootbox.min.js') !!}
    {!! HTML::script('js/icon-plugin.js?v=0.4') !!}
    {!! HTML::script('js/tag-it/js/tag-it.js') !!}

    <script>
        $(document).ready(function () {
            var count = "{!! $count !!}";

//            $("body").on('click', '.delete-term', function () {
//                $(this).parents().eq(1).remove();
//            });

            $("body").on('click', '#save-tax-data', function () {
                $('#tax_title').val($('.vname').val());
                $('#tax_description').val($('.vdesc').val());
                $('#tax_icon').val($("[name='icon']").val());
//               $('#tax_image').val();
//               $('#tax_icon').val();
                $('.panel-virtual').html('');
            });

            $("body").on('click', '#save-term-data', function () {
                var title = $('.vname').val();
                var description = $('.vdesc').val();
                var icon = $("[name='icon']").val();
                count = parseInt(count) + 1;
                $.ajax({
                    type: "post",
                    url: "{!! url('/admin/manage/frontend/classify/generate-term') !!}",
                    cache: false,
                    datatype: "json",
                    data: {
                        title: title,
                        description: description,
                        count: count,
//                        image : tax_image,
                        icon: icon
                    },
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    success: function (data) {
                        if (!data.error) {
                            $('.terms-box').append(data.html).after();

                            $("#classify_modal").modal('hide');
                            $('.classify_modal_body').html('');
                        }
                    }
                });

//               $('#tax_image').val();
//               $('#tax_icon').val();
                $('.panel-virtual').html('');
            });

            $("body").on('click', '.edit-taxonomy', function () {
                var id = $(this).data('id');
                $.ajax({
                    type: "post",
                    url: "{!! url('/admin/manage/frontend/classify/get-taxonomy-form') !!}",
                    cache: false,
                    datatype: "json",
                    data: {
                        id: id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    success: function (data) {
                        if (!data.error) {
                            $('.classify_modal_body').html(data.html);
                            $("#classify_modal").modal();
                        }
                    }
                });
            });

            $("body").on('click', '.add-tax', function () {
                $.ajax({
                    type: "post",
                    url: "{!! url('/admin/manage/frontend/classify/get-taxonomy-form') !!}",
                    cache: false,
                    datatype: "json",
                    data: {},
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    success: function (data) {
                        if (!data.error) {
                            $('.classify_modal_body').html(data.html);
                            $("#classify_modal").modal();
                        }
                    }
                });
            });

            $("body").on('click', '.add-term', function () {
                var classifier = $(this).data('classifier')
                $.ajax({
                    type: "post",
                    url: "{!! url('/admin/manage/frontend/classify/get-taxonomy-form') !!}",
                    cache: false,
                    datatype: "json",
                    data: {
                        terms: true,
                        classifier: classifier
                    },
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    success: function (data) {
                        if (!data.error) {

                            $('.classify_modal_body').html(data.html);
                            $("#classify_modal").modal();
                        }
                    }
                });
            });

            $("body").on('click', '.edit-term', function () {
                var id = $(this).data('id');
                var classifier = $(this).data('classifier')
                $.ajax({
                    type: "post",
                    url: "{!! url('/admin/manage/frontend/classify/get-taxonomy-form') !!}",
                    cache: false,
                    datatype: "json",
                    data: {
                        terms: true,
                        id: id,
                        classifier: classifier

                    },
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    success: function (data) {
                        if (!data.error) {
                            $('.classify_modal_body').html(data.html);
                            $("#classify_modal").modal();
                        }
                    }
                });
            });

            $("body").on('click', '#edit-term-data', function () {
                var title = $('.vname').val();
                var description = $('.vdesc').val();
                var icon = $("[name='icon-term']").val();
                var dataCount = $(this).data('count');
                console.log(dataCount);
                $("[data-count=" + dataCount + "]").attr('data-title', title);
                $("[data-count=" + dataCount + "]").attr('data-desc', description);


                $(".title-area-" + dataCount).text(title);
                $(".title_" + dataCount).val(title);
                $(".description_" + dataCount).val(description);
                $(".icon_" + dataCount).val(icon);
                $("[bb-icon='" + dataCount + "']").attr('class', icon);

                $("#classify_modal").modal('hide');
                $('.classify_modal_body').html('');
            });


            $('#menus-list').nestedSortable({
                handle: 'div.drag-handle',
                items: 'li',
                maxLevels: 3,
                toleranceElement: '> div',
                update: function (event, ui) {
                    var item = $(ui.item[0]);
                    var parentid = item.closest('ol').closest('li').data('item')
                    var ID = item.data('item');
                    if (parentid) {
                        item.attr('data-parent', parentid);
                        $(".icon_parent_" + ID).val(parentid);
                    } else {
                        item.attr('data-parent', '0')
                        $(".icon_parent_" + ID).val(0);
                    }
                }


            });


        });
    </script>
@stop