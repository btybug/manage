@extends('cms::layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <h2 class="m-t-0">Classifier</h2>

        </div>
        {!! Form::model($model) !!}
        <div class="col-md-12 toolbarNav m-b-10 p-b-5">
            <div class="col-md-9">
                <div class="form-inline">
                    <div class="form-group p-r-10 p-b-5  m-0">
                        <label for="name" class="p-r-10">Name</label>
                        {!! Form::text('title',null,['class' => 'form-control','id' => 'tax_title']) !!}
                        {!! Form::hidden('description',null,['id' => 'tax_description']) !!}
                        {!! Form::hidden('image',null,['id' => 'tax_image']) !!}
                        {!! Form::hidden('icon',null,['id' => 'tax_icon']) !!}
                        <a href="javascript:void(0)" class="btn btn-ls edit-taxonomy"><i class="fa fa-edit"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-right">
                {!! Form::submit('Save Classifier', array('class' => 'btn btn-danger btn-danger-red', 'data-save' => 'taxonomy' )) !!}
            </div>
        </div>



        <div class="col-md-4">
            <div class="col-md-12 menu_childs">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading bg-black-darker text-white"  role="tab" id="headingLink1">
                             <span  class="panel_title">Create Classifier Items</span>
                            <a href="javascript:void(0)" class="btn btn-md add-term"><i class="fa fa-plus"></i></a>
                            <a role="button" class="panelcollapsed collapsed" data-toggle="collapse"
                               data-parent="#accordion" href="#collapseLink_create_terms1" aria-expanded="true" aria-controls="collapseLink_create_terms1">
                                <i class="fa fa-chevron-down" aria-hidden="true"></i>
                            </a>
                            <ul class="list-inline panel-actions">
                                <li><a href="#" panel-fullscreen="true" role="button" title="Toggle fullscreen"><i class="glyphicon glyphicon-resize-full"></i></a></li>
                            </ul>
                        </div>
                        <div id="collapseLink_create_terms1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingLink1">
                        <div class="panel-body panel_body panel_1 show">
                            <ol id="menus-list" class="sortable ui-sortable ui-droppable dvmin-height terms-box">
                                {!! \Sahakavatar\Manage\Models\Classifier::RecursiveTerms($terms) !!}
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading bg-black-darker text-white" role="tab" id="headingLink1">
                    <a role="button" class="panelcollapsed collapsed" data-toggle="collapse"
                       data-parent="#accordion" href="#collapseLink_edit_place1" aria-expanded="true" aria-controls="collapseLink_edit_place1">
                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                    </a>
                   <span  class="panel_title"> Edit place</span>
                    <ul class="list-inline panel-actions">
                        <li><a href="#" panel-fullscreen="true" role="button" title="Toggle fullscreen"><i class="glyphicon glyphicon-resize-full"></i></a></li>
                    </ul>
                </div>
                <div id="collapseLink_edit_place1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingLink1">
                <div class="panel-body panel-virtual panel_body panel_1 show">

                </div>
            </div>
        </div>


    </div>


    @include('resources::assests.magicModal')
@stop
@section('CSS')
    {!! HTML::style('/resources/assets/css/menu.css?v=0.16') !!}
    {!! HTML::style('/resources/assets/css/tool-css.css?v=0.23') !!}
    {!! HTML::style('/resources/assets/css/page.css?v=0.15') !!}
@stop

@section('JS')
    {!! HTML::script('/resources/assets/js/nestedSortable/jquery.mjs.nestedSortable.js') !!}
    {!! HTML::script('/resources/assets/js/bootbox/js/bootbox.min.js') !!}
    {!! HTML::script('/resources/assets/js/icon-plugin.js?v=0.4') !!}
    {!! HTML::script("/resources/assets/js/UiElements/bb_styles.js?v.5") !!}
    {!! HTML::script('resources/assets/js/admin_pages.js') !!}
    <script>
        $(document).ready(function () {
            var count = "{!! $count !!}";

            $("body").on('click', '.delete-term', function () {
                $(this).parents().eq(1).remove();
            });

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
                        'X-CSRF-TOKEN':$("input[name='_token']").val()
                    },
                    success: function (data) {
                        if (!data.error) {
                            $('.terms-box').append(data.html).after();
                        }
                    }
                });

//               $('#tax_image').val();
//               $('#tax_icon').val();
                $('.panel-virtual').html('');
            });

            $("body").on('click', '.edit-taxonomy', function () {
                var tax_name = $('#tax_title').val();
                var tax_desc = $('#tax_description').val();
                var tax_image = $('#tax_image').val();
                var tax_icon = $("[name='icon']").val();
                $.ajax({
                    type: "post",
                    url: "{!! url('/admin/manage/frontend/classify/get-taxonomy-form') !!}",
                    cache: false,
                    datatype: "json",
                    data: {
                        title: tax_name,
                        description: tax_desc,
                        image: tax_image,
                        icon: tax_icon
                    },
                    headers: {
                        'X-CSRF-TOKEN':$("input[name='_token']").val()
                    },
                    success: function (data) {
                        if (!data.error) {
                            $('.panel-virtual').html(data.html);
                        }
                    }
                });
            });

            $("body").on('click', '.add-term', function () {
                $.ajax({
                    type: "post",
                    url: "{!! url('/admin/manage/frontend/classify/get-taxonomy-form') !!}",
                    cache: false,
                    datatype: "json",
                    data: {
                        terms: true
                    },
                    headers: {
                        'X-CSRF-TOKEN':$("input[name='_token']").val()
                    },
                    success: function (data) {
                        if (!data.error) {
                            $('.panel-virtual').html(data.html);
                        }
                    }
                });
            });


            $("body").on('click', '.edit-term', function () {
                var title = $(this).attr('data-title');
                var desc = $(this).attr('data-desc');
                var icon = $("[name='icon-term']").val();
                var count = $(this).attr('data-count');
                $.ajax({
                    type: "post",
                    url: "{!! url('/admin/manage/frontend/classify/get-taxonomy-form') !!}",
                    cache: false,
                    datatype: "json",
                    data: {
                        edit: true,
                        title: title,
                        description: desc,
                        icon: icon,
                        count: count,
                        terms: true
                    },
                    headers: {
                        'X-CSRF-TOKEN':$("input[name='_token']").val()
                    },
                    success: function (data) {
                        if (!data.error) {
                            $('.panel-virtual').html(data.html);
                        }
                    }
                });
            });

            $("body").on('click', '#edit-term-data', function () {
                var title = $('.vname').val();
                var description = $('.vdesc').val();
                var icon = $("[name='icon-term']").val();
                var dataCount = $(this).data('count');

                $(".title-area-" + dataCount).text(title);
                $(".title_" + dataCount).val(title);
                $(".description_" + dataCount).val(description);
                $(".icon_" + dataCount).val(icon);
                $("[bb-icon='" + dataCount + "']").attr('class', icon);
                $('.panel-virtual').html('');
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
