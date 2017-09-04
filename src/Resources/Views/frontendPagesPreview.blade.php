<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js" xmlns="http://www.w3.org/1999/html">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <title>BB Admin Framework - Pages Preview</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    {!! HTML::style('js/jquery-ui/jquery-ui.min.css') !!}
    {!! HTML::style('css/cms.css') !!}
    {!! HTML::script("js/jquery-2.1.4.min.js") !!}
    {!! HTML::script("js/jquery-ui/jquery-ui.min.js") !!}
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    {!! HTML::script("js/tinymice/tinymce.min.js") !!}
    {!! HTML::style("css/animate/css/animate.css") !!}
    {!! HTML::style("css/font-awesome/css/font-awesome.min.css") !!}
    @yield('CSS')
    @stack('css')
</head>
<body>
<div class="container-fluid coreheadersetting m-b-10">
    <div class="row">
          <div class="col-xs-4 p-t-10">
          </div>
          <div class="col-xs-4  p-t-10">
                 <div class="col-md-6">
                     <button class="btn btn-info" data-settingaction="save"> save</button>
                 </div>
              <div class="col-md-3">
                     {!! BBbutton('page_sections','layout_id','Select Page Section',['class'=>'btn selectGrayBtn rightSelectBtn change-layout','data-type'=>'frontend','model' => (isset($_GET['pl'])) ? $_GET['pl'] : null]) !!}
                 </div>
                 <div class="col-md-3">
                 </div>
          </div>
    </div>
</div>
<header class="hide">
    @include('manage::frontend.pages._partials.preview_header')
</header>
<div class="modal fade" id="magic-settings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {{--{!! Form::open(['url'=>'/admin/backend/theme-edit/live-save', 'id'=>'magic-form']) !!}--}}
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
<div class="previewlivesetting" >
      <div data-loadifram="preview">
        @yield('content')
      </div>
      <div>
           @yield('settings')
      </div>
      <input type="text" class="hide" datas-settingjson />
</div>
{!! csrf_field() !!}
@include('resources::assests.magicModal')
</body>
{!! HTML::script("js/UiElements/bb_styles.js?v.5") !!}
{!! HTML::script("js/UiElements/bb_div.js?v.5") !!}
@yield('JS')
@stack('javascript')
</html>