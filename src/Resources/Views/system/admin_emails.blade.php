@extends('cms::layouts.mTabs',['index'=>'manage_settings'])
@section('tab')


<div class="m-t-10" id="system">
  <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 panels_wrapper panel_wrap">
    {!! Form::open(['url' => '/admin/settings/system/adminemails','role' => 'form', 'class'=>'config-form ']) !!}
    <div class="panel panel-default panels accordion_panels">
      <div class="panel-heading bg-black-darker text-white"  role="tab" id="headingLink">
        <span  class="panel_title">System</span>
        <a role="button" class="panelcollapsed collapsed" data-toggle="collapse"
           data-parent="#accordion" href="#collapseLink2" aria-expanded="true" aria-controls="collapseLink1">
          <i class="fa fa-chevron-down" aria-hidden="true"></i>
        </a>
        <ul class="list-inline panel-actions">
          <li><a href="#" panel-fullscreen="true" role="button" title="Toggle fullscreen"><i class="glyphicon glyphicon-resize-full"></i></a></li>
        </ul>
      </div>
      <div id="collapseLink2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingLink">
      <div class="panel-body panel_body panel_1 show">

  			    {!! Form::label('info','Info',[])!!}
				{!! Form::input('text','info',@$emails['info'],['class'=>'form-control','placeholder'=>'Info Email'])!!}

  			    {!! Form::label('support','Support',['class'=>'m-t-20'])!!}
				{!! Form::input('text','support',@$emails['support'],['class'=>'form-control','placeholder'=>'Info Email'])!!}

  			    {!! Form::label('admin','Admin',['class'=>'m-t-20'])!!}
				{!! Form::input('text','admin',@$emails['admin'],['class'=>'form-control','placeholder'=>'Info Email'])!!}

  			    {!! Form::label('sales','Sales',['class'=>'m-t-20'])!!}
				{!! Form::input('text','sales',@$emails['sales'],['class'=>'form-control','placeholder'=>'Info Email'])!!}

  			    {!! Form::label('technical_staff','Technical Staff',['class'=>'m-t-20'])!!}
				{!! Form::input('text','technical_staff',@$emails['technical_staff'],['class'=>'form-control','placeholder'=>'Info Email'])!!}
                
                {!! Form::submit(isset($buttonText) ? $buttonText : "Save",['class' => 'btn btn-primary btn-block m-t-20 ']) !!}
      </div>
    </div>
    {!! Form::close() !!}
  </div>
</div>
  </div>



@stop
@section('CSS')
  {!! HTML::style('/resources/assets/css/menu.css?v=0.16') !!}
  {!! HTML::style('resources/assets/css/admin_pages.css') !!}
  {!! HTML::style('/resources/assets/css/tool-css.css?v=0.23') !!}
  {!! HTML::style('/resources/assets/css/page.css?v=0.15') !!}
  @
@stop


@section('JS')
  {!! HTML::script("/resources/assets/js/UiElements/bb_styles.js?v.5") !!}
  {!! HTML::script('resources/assets/js/admin_pages.js') !!}
  {!! HTML::script('/resources/assets/js/nestedSortable/jquery.mjs.nestedSortable.js') !!}
  {!! HTML::script('/resources/assets/js/bootbox/js/bootbox.min.js') !!}
  {!! HTML::script('/resources/assets/js/icon-plugin.js?v=0.4') !!}
@stop
