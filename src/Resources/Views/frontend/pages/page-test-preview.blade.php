@extends('layouts.frontendPagesPreview')

@section('content')
    <div class="previewlivesettingifream" style="background: white;">
        <div class="normal">{!! (isset($data['layout'])?BBRenderPageSections($data['layout'],$data['settings']):BBRenderPageBody($data['page']->slug,$data['settings'])) !!}</div>
    </div>
    <div id="previewImageifreamimage"></div>
@stop

@section('CSS')
    {!! HTML::style('css/create_pages.css') !!}
    {!! HTML::style('css/preview-template.css') !!}
    {!! HTML::style("/js/animate/css/animate.css") !!}
    {!! HTML::style("/css/preview-template.css") !!}
@stop

@section('JS')
    {!! HTML::script("js/html2canvas/js/html2canvas.js") !!}
    {!! HTML::script("js/canvas2image/js/canvas2image.js") !!}
    {!! HTML::script("js/bootbox/js/bootbox.min.js") !!}
    {!! HTML::script("js/UiElements/ui-page-preview-setting.js") !!}


    <script>
        $(document).ready(function () {
            $('body').on('click', '.item', function () {
				var datasetting = $('[datas-settingjson]').val();
				var pagelsod = $(this).find('input').attr('data-action');
				if(pagelsod === "page_sections"){
					if($(this).hasClass('m-item')){
						var mw = $(this).data('value');
						if(mw){
							var currentUrl = window.location.pathname;
							var pl = findGetParameter('pl');
							if(pl){
							   var url = currentUrl + "?mw=" + mw + "&pl="+pl+'&pl_live_settings=page_live';
							}else{
								var url = currentUrl + "?mw=" + mw + '&pl_live_settings=page_live';
							}
//							window.location.href = url
						}
					}else{
						var layoutID = $(this).data('value');
						if(layoutID){
							var currentUrl = window.location.pathname;
							var mw = findGetParameter('mw');
							if(mw){
								var url = currentUrl + "?mw=" + mw +  "&pl="+layoutID+'&pl_live_settings=page_live';
							}else{
								var url = currentUrl + "?pl="+layoutID+'&pl_live_settings=page_live';
							}
//							window.location.href = url;
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