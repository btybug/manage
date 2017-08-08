@extends('cms::layouts.mTabs',['index'=>'frontend_manage'])
@section('tab')
    <div role="tabpanel" class="m-t-10" id="main">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 main_container_11">
            <div class="col-md-3">
                <div class="row">
                    {!! Form::select('type',['core' => 'Core','modules' => "Module",'plugins' => 'Plugins','addons' => 'Add-on'],$type,['class' => 'form-control select-type']) !!}
                </div>
                @if(count($data))
                    @foreach($data as $key =>  $value)
                        @if(count($value))
                            @foreach($value as $k =>  $bb)
                                @if($slug == $k)
                                    <div>
                                        <a class="btn btn-large btn-warning"
                                           href="?slug={{ $k }}&structure={{ $key }}&type={{ $type }}">{{ $bb['title'] }}</a>
                                    </div>
                                @else
                                    @if($current['function'] == $bb['function'])
                                        <div>
                                            <a class="btn btn-large btn-warning"
                                               href="?slug={{ $k }}&structure={{ $key }}&type={{ $type }}">{{ $bb['title'] }}</a>
                                        </div>
                                    @else
                                        <div>
                                            <a class="btn btn-large btn-info"
                                               href="?slug={{ $k }}&structure={{ $key }}&type={{ $type }}">{{ $bb['title'] }}</a>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                @else
                    NO BB Functions
                @endif
            </div>
            <div class="col-md-9" style="border-left: 3px solid red;">
                @if($current)
                    <div class="row">
                        <p><b>Function Name:</b> {{ $current['function'] }} </p>
                        <p><b>Params:</b> {{ ($current['params']) ? $current['params'] : "No Params" }}</p>
                        <p><b>Description:</b> {{ $current['description'] }} </p>
                        <p><b>Structure:</b> {{ ($structure) ? \App\Models\ExtraModules\Structures::find($structure)->name : "Core" }} </p>
                    </div>
                    <div class="row">
                        <h3>Example of function </h3>
                        @if($current['example'])
                            @php
                            $function=$current['example'];
                            eval(" echo $function;")
                            @endphp
                        @else
                            Empty example
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
    @include('resources::assests.magicModal')
@stop
@section('CSS')
    {!! HTML::style('css/menu.css?v=0.16') !!}
    {!! HTML::style('css/admin_pages.css') !!}
    {!! HTML::style('css/tool-css.css?v=0.23') !!}
    {!! HTML::style('css/page.css?v=0.15') !!}
@stop


@section('JS')
    {!! HTML::script("/resources/assets/js/UiElements/bb_styles.js?v.5") !!}
    {!! HTML::script('js/admin_pages.js') !!}
    {!! HTML::script('js/nestedSortable/jquery.mjs.nestedSortable.js') !!}
    {!! HTML::script('js/bootbox/js/bootbox.min.js') !!}
    {!! HTML::script('js/icon-plugin.js?v=0.4') !!}

    <script>

        $(document).ready(function () {
            $("body").on('change', '.select-type', function () {
                var value = $(this).val();
                window.location.href = "/admin/manage/frontend/filters?type=" + value;
            });
        });

    </script>
@stop
