@extends('cms::layouts.mTabs',['index'=>'frontend_manage'])
@section('tab')
    {!! HTML::style('app/Modules/Resources/Resources/assets/css/new-store.css') !!}
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cms_module_list">
            <h3 class="menuText f-s-17 hide">
                <span class="module_icon_main"></span>
            </h3>
            <div class=" menuBox">
                <a href="javascript:void(0)" class="btn btn-danger addBtn"><i class="fa fa-plus"></i></a>
                <div class="selectCat">
                    <select class="selectpicker " data-style="selectCatMenu" data-width="100%">
                        <option>Categories</option>
                        <option>option</option>
                        <option>option 2</option>
                    </select>
                </div>
            </div>
            <hr>
            <ul class="list-unstyled menuList" id="components-list">
                @if(count($menus))
                    @foreach($menus as $value)
                        <li>
                            <a href="?p={{ $value->getBasename('.json') }}" rel="tab" class="tpl-left-items">
                                <span class="module_icon"></span>  {{ $value->getBasename('.json') }}
                            </a>
                        </li>
                    @endforeach
                @else
                    no menus
                @endif

            </ul>
        </div>



        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
            <div class="row">
            </div>
            <div class="row template-search">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 template-search-box m-t-10 m-b-10">
                    <form class="form-horizontal">
                        <div class="form-group m-b-0  ">
                            <label for="inputEmail3" class="control-label text-left"><i class="fa fa-sort-amount-desc"></i> Sort By</label>
                            <select class="selectpicker" data-style="selectCatMenu" data-width="50%">
                                <option>Recently Added</option>
                            </select>

                        </div>
                    </form>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 p-l-0 p-r-0">
                    <div class="template-upload-button clearfix">
                        <div class="rightButtons">
                            <div class="btn-group listType">
                                <a href="#" class="btn btnListView"><i class="fa fa fa-th-list"></i></a>
                                <a href="#" class="btn btnGridView active"><i class="fa fa-th-large"></i></a>
                            </div>
                            <a class="btn btn-default searchBtn"><i class="fa fa-search " aria-hidden="true"></i></a>
                        </div>

                        <ul class="editIcons list-unstyled ">
                            <li><a href="#" class="btn trashBtn"><i class="fa fa-trash-o"></i></a></li>
                            <li><a href="#" class="btn copyBtn"><i class="fa fa-clone"></i></a></li>
                            <li><a href="#" class="btn editBtn"><i class="fa fa-pencil"></i></a></li>
                        </ul>

                        <button class="btn btn-sm pull-right btnUploadWidgets" type="button" data-toggle="modal"
                                data-target="#uploadfile">
                            <i class="fa fa-cloud-upload module_upload_icon"></i> <span class="upload_module_text">Upload</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="templates-list  m-t-20 m-b-10">
                <div class="row m-b-10">
                    {!! HTML::image('resources/assets/images/ajax-loader5.gif', 'a picture', array('class' => 'thumb img-loader hide')) !!}
                    <div class="raw tpl-list">
                        @if(count($menus))
                            @include('console::modules.settings._partials.list_menu_variations')
                        @endif
                    </div>
                </div>
            </div>

            <div class="loadding"><em class="loadImg"></em></div>
            <nav aria-label="" class="text-center">
                <ul class="pagination paginationStyle">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active">
                        <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
            <div class="text-center"><button type="button" class="btn btn-lg btn-primary btnLoadmore"><em class="loadImg"></em> Load more</button></div>

        </div>
    </div>

    <div class="modal fade" id="uploadfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Upload</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['url'=>'','class'=>'dropzone', 'id'=>'my-awesome-dropzone']) !!}

                    {!! Form::close() !!} </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="newMenu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Create Menu</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['id'=>'add-menu']) !!}
                    Menu Name:   {!! Form::text('name',null,['class' => 'form-control']) !!}

                    {!! Form::submit('Create',['class' => 'btn btn-success']) !!}
                    {!! Form::close() !!} </div>
            </div>
        </div>
    </div>


    @include('resources::assests.deleteModal',['title'=>'Delete Widget'])
@stop
@section('CSS')
    {!! HTML::style('js/bootstrap-select/css/bootstrap-select.min.css') !!}
    <style>
        .child-tpl {
            width: 95% !important;
        }

        .img-loader {
            width: 70px;
            height: 70px;
            position: absolute;
            top: 50px;
            left: 40%;
        }

    </style>
@stop
@section('JS')
    {!! HTML::script('js/dropzone/js/dropzone.js') !!}
    {!! HTML::script('js/bootstrap-select/js/bootstrap-select.min.js') !!}
    <script>
        Dropzone.options.myAwesomeDropzone = {
            init: function() {
                this.on("success", function(file) {
                    location.reload();

                });
            }
        };

        $(document).ready(function () {
            $(".addBtn").on('click',function(){
                $("#newMenu").modal();
            });
        });

    </script>
@stop