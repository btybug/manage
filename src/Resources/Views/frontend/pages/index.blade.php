@extends('cms::layouts.mTabs',['index'=>'frontend_manage'])
@section('tab')
    <div class="m-b-20 col-md-3 m-l-20">
        {!! Form::select('type',['core' => 'Core','plugin' => "Module",'custom' => 'Custom','classify' => 'Classify','tags' => 'Tags'],$type,['class' => 'form-control select-type']) !!}
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <article>
            @if($page && $page->type == "custom")
                <div class="m-b-10">

                    {!! Form::open(['url' => "/admin/manage/frontend/pages/new"]) !!}
                    {{ Form::button('<i class="fa fa-plus" aria-hidden="true"></i> New Page', array('type' => 'submit', 'class' => 'create_new_btn m-l-20')) }}
                    {!! Form::close() !!}
                </div>
            @endif
            {{--<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">--}}
                {{--@if(count($pages))--}}
                    {{--@if($type == 'classify')--}}
                <div class="col-md-8 col-md-offset-2">
                        {!! hierarchyAdminPagesListFull($pages) !!}
                </div>
                    {{--@else--}}
                        {{--@foreach($pages as $p)--}}
                            {{--<li class="panel panel-default page_col">--}}
                                {{--@if(isset($_GET['p']) && $_GET['p'] == $p->id)--}}
                                    {{--<div class="panel-heading" style="background-color: black;color:white;" role="tab"--}}
                                         {{--id="headingOne">--}}
                                {{--@else--}}
                                    {{--@if($loop->first == $p->id && ! isset($_GET['p']))--}}
                                        {{--<div class="panel-heading" style="background-color: black;color:white;"--}}
                                             {{--role="tab" id="headingOne">--}}
                                    {{--@else--}}
                                        {{--<div class="panel-heading" role="tab" id="headingOne">--}}
                                    {{--@endif--}}
                                {{--@endif--}}

                                    {{--<h4 class="panel-title">--}}
                                        {{--<a href="?type={{ $type }}&p={{ $p->id }}"--}}
                                           {{--aria-expanded="true"--}}
                                           {{--class="link_name">--}}
                                            {{--{{ $p->title }}--}}
                                        {{--</a>--}}
                                    {{--</h4>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                        {{--@endforeach--}}
                    {{--@endif--}}
                {{--@else--}}
                    {{--<li class="panel panel-default page_col">--}}
                        {{--<div class="panel-heading" role="tab" id="headingOne">--}}
                            {{--<h4 class="panel-title">--}}
                                {{--<a data-toggle="collapse" href="#" aria-expanded="true" aria-controls="collapseOne"--}}
                                   {{--class="link_name collapsed">--}}
                                    {{--No Pages--}}
                                {{--</a>--}}
                            {{--</h4>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                {{--@endif--}}
            {{--</div>--}}

            {{--<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 buttons page-data">--}}
{{--                @include('manage::frontend.pages._partials.page-data')--}}

            {{--</div>--}}

        </article>
    </div>

    @include('cms::_partials.delete_modal')
@stop
{{--@include('tools::common_inc')--}}
@section('CSS')
    {!! HTML::style('/css/create_pages.css') !!}
    {!! HTML::style('/css/menu.css?v=0.16') !!}
    {!! HTML::style('/css/tool-css.css?v=0.23') !!}
    {!! HTML::style('/css/page.css?v=0.15') !!}
    {!! HTML::style('/css/admin_pages.css') !!}
    {!! HTML::style('/css/jquery.tagit.css') !!}
    {!! HTML::style('/css/select2/select2.min.css') !!}

@stop

@section('JS')
    {!! HTML::script('/js/create_pages.js') !!}
    {!! HTML::script("/js/UiElements/bb_styles.js?v.5") !!}
    {!! HTML::script('/js/admin_pages.js') !!}
    {!! HTML::script('/js/nestedSortable/jquery.mjs.nestedSortable.js') !!}
    {!! HTML::script('/js/bootbox/bootbox.min.js') !!}
    {!! HTML::script('/js/icon-plugin.js?v=0.4') !!}
    {!! HTML::script('/js/tag-it/tag-it.js') !!}
    {!! HTML::script('/js/select2/select2.full.min.js') !!}
    <script>

        $(document).ready(function () {

            $("body").on('click', '[data-collapse]', function () {
                var id = $(this).attr('data-collapse');
                $('li[data-id='+id+'] ol').slideToggle();
                $(this).toggleClass('fa-minus fa-plus');
            });

            $("body").on('click', 'li[data-id] .listinginfo', function () {
                var item_id = $(this).parent('li[data-id]').attr('data-id');
                $('.pagelisting .listinginfo.active_class').removeClass('active_class');
                $('li[data-id='+item_id+'] > .listinginfo').addClass('active_class');

            });
            $("body").on('change', '.select-type', function () {
                var value = $(this).val();
                window.location.href = "/admin/manage/frontend/pages?type=" + value;
            });

            $('.classify-options').select2({
                allowClear: false,
                placeholder: 'Select an option'
            });

            $('#tags').tagit({
                triggerKeys: ['enter', 'comma', 'tab', 'space'],
                fieldName: 'tags[]',
                availableTags: '',
                autocomplete: ({
                    source: function (request, response) {
                        $.ajax({
                            url: '/admin/manage/frontend/tags/clouds',
                            data: {format: "json", term: request.term},
                            dataType: 'json',
                            type: 'GET',
                            success: function (data) {
                                response($.map(data.data, function (item) {
                                    return {
                                        label: item,
                                        value: item
                                    }
                                }));
                            },
                            error: function (request, status, error) {
                                alert(error);
                            }
                        })
                    },
                    minLength: 1
                })
            });


            $("body").on('change', '.classify', function () {
                var id = $(this).val();
                if (typeof id != undefined && $(".data-cl[data-cl='" + id + "']").length === 0) {
                    var optionType = $('option:selected', this).attr('data-type');
                    $.ajax({
                        url: '/admin/manage/frontend/pages/classify',
                        data: {
                            id: id,
                            type: optionType
                        },
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $("input[name='_token']").val()
                        },
                        dataType: 'json',
                        success: function (data) {
                            if (!data.error) {
                                $(".classify-box").append(data.html);
                                $('.classify-options').select2({
                                    allowClear: false,
                                    placeholder: 'Select an option'
                                });
                            }
                        }
                    });
                }
            });

            $("body").on('click', '.delete-classify', function () {
                var id = $(this).data('id');
                $("[data-cl='" + id + "']").remove();
            });

            $("body").on('change', '[name="user_id"]', function () {
                var id = $(this).val();
                $.ajax({
                    url: '/admin/manage/frontend/pages/user-avatar',
                    data: {id: id},
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    success: function (data) {
                        $(".user_photo").html('<img src="' + data.url + '" alt="avatar" class="thumb-md-blue">');
                    },

                });

            });

            if ($('#tagits').length > 0) {
                var getExt = $('#tagits').data('allwotag').split(',')

                $('#tagits').tagit({
                    availableTags: getExt,
                    // This will make Tag-it submit a single form value, as a comma-delimited field.
                    autocomplete: {delay: 0, minLength: 0},
                    singleField: true,
                    singleFieldNode: $('.tagitext'),
                    beforeTagAdded: function (event, ui) {
                        if (!ui.duringInitialization) {
                            var exis = getExt.indexOf(ui.tagLabel);
                            if (exis < 0) {
                                $('.tagit-new input').val('');
                                //alert('PLease add allow at tag')
                                return false;
                            }
                        }

                    }
                })
            }
            fixbar()
            function fixbar() {
                var targetselector = $('.vertical-text');
                if (targetselector.length > 0) {
                    var getwith = targetselector.width()
                    var left = 0 - getwith / 2 - 15;
                    targetselector.css({'left': left, 'top': getwith / 2})
                }
            }

            var id;
            $("body").on('click', '[data-pagecolid]', function () {
                id = $(this).data('pagecolid');
                $.ajax({
                    url: '/admin/manage/frontend/pages/get-data',
                    data: {id: id},
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (!data.error) {
                            $('.page-data').html(data.html);
//                            $('.page_layout').val(data.value);
//                            $('.page_name').val(data.page_name);
//                            $('.page_address').html(data.page_url);
//                            $('.page-date').html(data.page_date);
//                            //apply content
//                            var applyC = $(".apply_contents").attr('href');
//                            var res = applyC.split('/');
//
//                            res[res.length - 1] = data.page_id + "?pl=" + data.value;
//                            res = res.join('/');
//
//                            $(".apply_contents").attr('href', res);
                        }
                    },

                });
            });

            $("body").on('change', '.page_layout', function () {
                var layoutID = $(this).val();
                var applyC = $(".apply_contents").attr('href');
                var res = applyC.split('/');
                var last = res[res.length - 1];

                var page = last.substring(-1, last.indexOf('?'));

                res[res.length - 1] = page + "?pl=" + layoutID;
                res = res.join('/');

                $(".apply_contents").attr('href', res);
            });

            $("body").on('click', '.add-new-adminpage', function () {
                $('#adminpage').modal();
            });

            $("body").on('click', '.module-info', function () {
                var id = $(this).attr('data-module');
                var item = $(this).find("i");
                $.ajax({
                    url: '/admin/backend/build/admin-pages/module-data',
                    data: {id: id},
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        $('.module-info-panel').html('');
                        item.removeClass('fa-info-circle');
                        item.addClass('fa-refresh');
                        item.addClass('fa-spin');
                    },
                    success: function (data) {
                        item.removeClass('fa-refresh');
                        item.removeClass('fa-spin');
                        item.addClass('fa-info-circle');
                        if (!data.error) {
                            $('.module-info-panel').html(data.html);
                        }
                    },
                    type: 'POST'
                });
            });

            $("body").on('click', '.view-url', function () {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: '/admin/backend/build/admin-pages/pages-data',
                    data: {
                        id: id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        $('.module-info-panel').html('');
                    },
                    success: function (data) {
                        if (!data.error) {
                            $('.module-info-panel').html(data.html);
                        }
                    },
                    type: 'POST'
                });
            });
        });
    </script>
@stop