@extends('layouts.admin')
@section('content')
  <div class="menu_page">
  {!! Form::open(['url'=>'/admin/manage/frontend/menus/create' , 'class' => 'form-horizontal']) !!}
  <div class="row toolbarNav m-b-10 p-b-5" >

    <div class="row">
      <div class="col-md-6 col-lg-6 name_input">
        <div class="form-inline">
          <div class="form-group p-r-10 p-b-5  m-0 ">
            <label for="classname" class="p-r-10">Title</label>
            {!! Form::text('name',null,['class'=>'form-control']) !!}</div>
          <div class="form-group p-r-10 p-b-5 m-0">
            {{-- <label for="classname" class="p-r-10">Menu Style</label>
           {!! Form::select('direction', ['0' => '--- Select ---', 'horizontal' => 'horizontal', 'vertical' => 'vertical'], null, ['class' => 'form-control', 'placeholder' => 'type', 'id' => 'type', 'data-change' =>'menustyle']) !!} --}}</div>
          <div class="form-group p-r-10 p-b-5 m-0">
            {{--<label for="classname" class="p-r-10">Menu Class</label>
            {!! Form::select('menu_class', null, null, ['class' => 'form-control', 'data-change' => 'menuclass']) !!} --}}</div>
        </div>
      </div>
      <div class="col-md-6 col-lg-6 text-right"><a href="#"  class="btn btn-default btn-default-gray">Discard</a> {!! Form::submit('Save Menu', array('class' => 'btn btn-danger btn-danger-red')) !!} </div>
    </div>
  </div>
  <div class="row">
    <!-- Item template used by JS -->
    <script type="template" id="item-template">
      <li data-details='[serialized_data]' [class]>
        <div class="drag-handle not-selected">
          [title]
          <div class="item-actions">
            <a href="javascript:;" data-action="Collapse">
              <i class="fa fa-arrow-down"></i> Collapse
            </a>
            <a href="javascript:;" data-action="delete"><i class="fa fa-trash-o"></i> Remove</a>
          </div>
          <div data-collapse="edit" class="collapse">ddf</div>
        </div>
        <ol></ol>
      </li>
    </script>
    <!-- END Item template -->



    <div class="col-md-4" >
      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default panel_list panel-row">
          <div class="panel-heading" role="tab" id="headingPages">
            <h4 class="panel-title">
              <a role="button" class="panelcollapsed collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                <i class="fa fa-arrow-down" aria-hidden="true"></i> </a>Pages</h4>
          </div>
          <div id="collapsePages" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingPages">
            <div class="panel-body"  class="panel-group" id="accordionsPages" role="tablist" aria-multiselectable="true">
              <ul class="list-group" data-nav-drag="">
                @foreach($pages as $page)
                  <li class="list-group-item" data-id="core_{!! $page['id']!!}" data-name="{!! $page['title']!!}" data-link="{!! $page['url']!!}" data-type="corepage">{!! @$page['title']!!}</li>
                  @if( isset($page['children']) )
                    @foreach($page['children'] as $page)
                      <li class="list-group-item" data-id="core_{!! $page['id']!!}" data-name="{!! $page['title']!!}" data-link="{!! $page['url']!!}" data-type="corepage">&nbsp;&nbsp;>&nbsp;{!! @$page['title']!!}</li>
                      @if( isset($page['children']) )
                        @foreach($page['children'] as $page)
                          <li class="list-group-item" data-id="core_{!! $page['id']!!}" data-name="{!! $page['title']!!}" data-link="{!! $page['url']!!}" data-type="corepage">&nbsp;&nbsp;&nbsp;&nbsp;>&nbsp;{!! @$page['title']!!}</li>
                        @endforeach
                      @endif
                    @endforeach
                  @endif
                @endforeach
              </ul>
            </div>
          </div>
        </div>




        <!--Pages -->
        <!--Custom Link-->
        <div class="panel panel-default panel_list panel-row">
          <div class="panel-heading" role="tab" id="headingLink">
            <h4 class="panel-title"> <a role="button" class="panelcollapsed collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseLink" aria-expanded="true" aria-controls="collapseLink">
                <i class="fa fa-arrow-down" aria-hidden="true"></i></a> Custom Link</h4>
          </div>
          <div id="collapseLink" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingLink">
            <div class="panel-body">
              <ul class="list-group"  data-nav-drag="">
                <li class="list-group-item" data-id="customlink" data-name="Custom Link" data-link='#' data-type="custom-link">Custom Link</li>
              </ul>
            </div>
          </div>
        </div>
        <!--Custom Link-->

        <!--Texnomies-->
        <div class="panel panel-default panel_list panel-row">
          <div class="panel-heading" role="tab" id="headingTexonomie">
            <h4 class="panel-title">
              <a role="button" class="panelcollapsed collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTexonomie" aria-expanded="true" aria-controls="collapseTexonomie">
                <i class="fa fa-arrow-down" aria-hidden="true"></i></a> Texonomie</h4>
          </div>
          <div id="collapseTexonomie" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTexonomie">
            <div class="panel-body"  class="panel-group" id="accordionstexonomie" role="tablist" aria-multiselectable="true">

              <!--Texnomies-->
              {{--@foreach($texonomies as $texonomie)--}}
              {{--<div class="panel panel-default">--}}
              {{--<div class="panel-heading" role="tab" id="headingtexonomie{!! $texonomie->id!!}" data-drag="{!! $texonomie->title!!}" data-id="texonomie_h_{!! $texonomie->id!!}" data-name="{!! $texonomie->title!!}" data-link="#" data-type="texonomiepages">--}}
              {{--<h4 class="panel-title"> <a role="button" data-toggle="collapse" data-parent="#accordionstexonomie" href="#collapsetexonomie{!! $texonomie->id!!}" aria-expanded="true" aria-controls="collapsetexonomie{!! $texonomie->id!!}">{!! $texonomie->title!!}</a> </h4>--}}
              {{--</div>--}}
              {{--<div id="collapsetexonomie{!! $texonomie->id!!}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingtexonomie{!! $texonomie->id!!}">--}}
              {{--<div class="panel-body">--}}
              {{--<ul class="list-group"  data-nav-drag="">--}}
              {{--@foreach($texonomie->terms as $term)--}}
              {{--<li class="list-group-item" data-id="texonomie_{!! $texonomie->id!!}_{!! $term->id!!}" data-name="{!! $term->term_name!!}" data-link="/pages/{!! $texonomie->slug !!}/{!! $term->term_slug!!}" data-type="{!! $texonomie->id!!}_Texonomy">{!! $term->term_name!!}</li>--}}
              {{--@endforeach--}}
              {{--</ul>--}}
              {{--</div>--}}
              {{--</div>--}}
              {{--</div>--}}
              {{--@endforeach --}}
            </div>
          </div>
        </div>
        <!--Texnomies-->

      </div>
    </div>

    <div class="col-md-8">
      <div class="panel panel-default panels accordion_panels">
        <div class="panel-heading bg-black-darker text-white menu_item" role="tab" id="headingLink">
       Menu Item
          <a role="button" class="panelcollapsed collapsed" data-toggle="collapse"
             data-parent="#accordion" href="#collapseLink_menu" aria-expanded="true" aria-controls="collapseLink_menu">
            <i class="fa fa-chevron-down" aria-hidden="true"></i>
          </a>
          <div class="buttons_area">
          <a href="/admin/manage/frontend/menus/menufile/menu" class="btn btn-default btn-xs" data-download="json" download="menujson.json">Download</a>
          <a href="#" class="btn btn-default btn-xs m-r-10 prev" data-preview="menu">Preview</a> </div>
        <ul class="list-inline panel-actions">
          <li><a href="#" panel-fullscreen="true" role="button" title="Toggle fullscreen"><i class="glyphicon glyphicon-resize-full"></i></a></li>
        </ul>
        </div>
      <div id="collapseLink_menu" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingLink">
        <div class="panel-body panel_body panel_1 show">
          <ol id="menus-list" class="sortable ui-sortable ui-droppable dvmin-height">
          </ol>
        </div>
      </div>
        </div>
      <div class="inputs col-xs-12 col-sm-12 col-md-6  col-lg-6">
      <input name="json_data" data-export="json" class="form-control" value=''>
      <input name="html_data" data-export="html" class="form-control" value=''></div>
    </div>

    <script type="template"  id="new-menu-item">
      <!-- Save Status -->
      <input type="hidden" name="save_state" value="add" />
      <form id="new-item-form">
        <input type="hidden" name="parent_id" value="0" />
        <input type="hidden" name="item_id" value="0" />
        <input type="hidden" name="menus_id" value="" />
        <input type="text" class="hide" name="link_type" value="" />
        <input type="text" class="hide" name="pagegroup" value="" />
        <input type="text" class="hide" name="groupItem" value="" />
        <div class="panel panel-default m-b-0">
          <div class="panel-body form-horizontal">
            <div data-optionfilter="heading" class="form-group text-center">
              <p>This is Dynamic Item Group. All of the items under this group will be displayed in the menu, this will include any new item added automatically</p>
            </div>
            <div class="form-group" data-optionfilter="notheading">
              <label for="edittext" class="col-sm-4 control-label">Item Name</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="edittext" placeholder="Text" name="title">
              </div>
            </div>
            <div class="form-group" data-optionfilter="notheading">
              <label for="editcustom-link" class="col-sm-4 control-label">Item URL</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="editcustom-link" placeholder="http://www.example.com/home" name="url" disabled>
              </div>
            </div>
            <div class="form-group">
              <label for="editclass" class="col-sm-4 control-label">Apply different Item class</label>
              <div class="col-sm-8">
                <input type="checkbox" name="hasclass" value="1">
              </div>
            </div>

            <div class="form-group hide" data-showhide="hasclass">
              <label for="editclass" class="col-sm-4 control-label">Item class</label>
              <div class="col-sm-8">
                <select class="form-control" id="editclass" name="class">
                  <option value="">Select Class</option>
                  <option value="item_class_1">Item Class 1</option>
                  <option value="item_class_2">Item Class 2</option>
                  <option value="item_class_3">Item Class 3</option>
                </select>

              </div>
            </div>

            <div class="form-group" data-optionfilter="notheading">
              <label class="col-sm-4 control-label" for="editicon">Icon</label>
              <div class="col-sm-8 removeindent">
                <a href="#" class="btn btn-default btn-sm" data-icon="iconbutton">Select Icon</a>
                <span class="iconView" data-iconSeting="">No Icon</span>
                <input type="text" name="icon" class="geticonseting">
              </div>
            </div>
            <div class="form-group">
              <label for="edituserstatus" class="col-sm-4 control-label">Desplay For</label>
              <div class="col-sm-8">
                <select class="form-control" id="edituserstatus" name="user_status">
                  <option value="both">Both</option>
                  <option value="before-login">Guest</option>
                  <option value="after-login">Loged in user</option>
                </select>
              </div>
            </div>
            <div class="form-group hide userrole">
              <label for="edituserrole" class="col-sm-4 control-label">User Group</label>
              <div class="col-sm-8"> {!! Form::select('user_role', [], null, ['class' => 'form-control','id'=>'edituserrole']) !!} </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 control-label" for="editopenNewtab"></label>
              <div class=" col-sm-8">
                <input type="checkbox" id="editopenNewtab" name="new_link">
                Open in new Tab? </div>
            </div>

            <p class="text-right p-r-15">
              <button type="button" class="btn btn-success save-item">Save</button>
              <button type="button" class="btn btn-default" data-action="cancel">Cancel</button>
            </p>
          </div>
        </div>
      </form>
    </script>
  </div>
    </div>

  <a href="#" class="btn btn-default btn-sm hide" id="icons">Edit</a> {!! Form::close() !!}
@section('CSS')
  <style data-saved="css">
  </style>
  {!! HTML::style('/resources/assets/css/menu.css?v=0.16') !!}
  {!! HTML::style('/resources/assets/css/tool-css.css?v=0.23') !!}
  {!! HTML::style('/resources/assets/css/page.css?v=0.15') !!}
  {!! HTML::style('resources/assets/css/admin_pages.css') !!}
@stop

@section('JS')
  {!! HTML::script('/resources/assets/js/bootbox/js/bootbox.min.js') !!}
  {!! HTML::script('/resources/assets/js/nestedSortable/jquery.mjs.nestedSortable.js') !!}
  {!! HTML::script('/resources/assets/js/front-menu.js?v=0.39') !!}
  {!! HTML::script('/resources/assets/js/icon-plugin.js?v=0.4') !!}
  {!! HTML::script('resources/assets/js/admin_pages.js') !!}
@stop

@stop

