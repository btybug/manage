@extends('btybug::layouts.mTabs',['index'=>'frontend_manage'])
@section('tab')
    <div role="tabpanel" class="m-t-10" id="main">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 main_container_11">
            <table class="table table-bordered" id="tpl-table">
                <thead>
                <tr class="bg-black-darker text-white">
                    <th>Name</th>
                    <th>Tag</th>
                    <th>Slug</th>
                    <th>Author</th>
                    <th>Type</th>
                    <th>Helper text</th>
                    <th>Created date</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                @if(count($hooks))
                    @foreach($hooks as $hook)
                        <tr>
                            <th>{{ $hook->name }}</th>
                            <th>{{ $hook->tag }}</th>
                            <th>{{ $hook->slug }}</th>
                            <th>{{ BBGetUser($hook->author_id) }}</th>
                            <th>{{ $hook->type }}</th>
                            <th>{{ $hook->help_text }}</th>
                            <th>{{ BBgetDateFormat($hook->created_at) }}</th>
                            <th>
                                <a href="{!! url("admin/manage/frontend/hooks/edit",$hook->id) !!}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                            </th>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <th  colspan="8" class="text-center">
                            No Hooks
                        </th>
                    </tr>
                @endif
                </tbody>
            </table>
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
@stop
