@extends('layouts.frontendPagesPreview')

@section('content')
    <div class="previewlivesettingifream" style="background: white;">
        @if($data['page'])
            @if(! starts_with($data['url'],"/"))
                <?php $data['url'] = "/" . $data['url']; ?>
            @endif
            @if(isset($_GET['pl_live_settings']))
                <iframe src="{{ $data['url'].'?pl='. $data['layout'].'&pl_live_settings=page_live&page_id='.$data['page_id'].'&mw='.$data['main_view'] }}"
                        id="iframeinfor"></iframe>
            @else
                {{--<iframe src="{{ $data['url'].'?pl='. $data['layout'].'&page_id='.$data['page_id'].'&mw='.$data['main_view'] }}"--}}
                        {{--id="iframeinfor">--}}

                {{--</iframe>--}}
                    <iframe src="http://www.bbc.com/"
                        id="iframeinfor"></iframe>
            @endif

            <div class="iframenotclickable"></div>
        @else
            Admin Page can't be rendered
        @endif
    </div>
    <div id="previewImageifreamimage"></div>
@stop

@section('CSS')
    {!! HTML::style('resources/assets/css/create_pages.css') !!}
    {!! HTML::style('/resources/assets/css/preview-template.css') !!}
    {!! HTML::style("resources/assets/js/animate/css/animate.css") !!}
    {!! HTML::style("resources/assets/css/preview-template.css") !!}
@stop

@section('JS')
    {!! HTML::script("resources/assets/js/html2canvas/js/html2canvas.js") !!}
    {!! HTML::script("resources/assets/js/canvas2image/js/canvas2image.js") !!}
    {!! HTML::script("resources/assets/js/bootbox/js/bootbox.min.js") !!}
    {!! HTML::script("resources/assets/js/UiElements/ui-page-preview-setting.js") !!}


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
							window.location.href = url
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