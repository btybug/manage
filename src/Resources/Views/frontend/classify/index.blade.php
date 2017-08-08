@extends('cms::layouts.mTabs',['index'=>'frontend_manage'])
@section('tab')

    <div class="up">
        <a href="javascript:">
            <button class="btn btn-sm btn-danger m-b-10 delete_all" type="button"><i class="fa fa-trash"></i> Delete
                Selected
            </button>
        </a>
        <a href="{!!url('/admin/manage/frontend/classify/create')!!}">
            <button class="btn btn-sm btn-success m-b-10 delete_all" type="button"><i class="fa fa-plus" aria-hidden="true"></i> Create Taxonomy</button>
        </a>

    </div>

    <div class="row">
        <div class="col-md-12 p-0">
            <table class="table table-bordered" id="tpl-table">
                <thead>
                <tr class="bg-black-darker text-white">
                    <th>Name</th>
                    <th>Image</th>
                    <th>Icon</th>
                    <th>Description</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @if(count($taxonomies))
                        @foreach($taxonomies as $taxonomy)
                            <tr>
                                <th>{{ $taxonomy->title }}</th>
                                <th>
                                    @if($taxonomy->image)
                                        <img alt="{!! $taxonomy->name !!}" src="{{ $taxonomy->image }}" width="100" height="100">
                                    @else
                                        <span class="alert-warning">No Image</span>
                                    @endif
                                </th>
                                <th>
                                    @if($taxonomy->icon)
                                        <i class="{!! $taxonomy->icon !!}"></i>
                                    @else
                                        <span class="alert-warning">No Icon</span>
                                    @endif
                                </th>
                                <th>{{ $taxonomy->description }}</th>
                                <th>
                                    <a href="{!! url('admin/manage/frontend/classify/edit',$taxonomy->id)!!}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                    <a  href="{!! url('admin/manage/frontend/classify/delete',$taxonomy->id)!!}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                </th>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop
@push('css')
{!! HTML::style('css/admin_pages.css') !!}
@endpush
@push('javascript')
@endpush