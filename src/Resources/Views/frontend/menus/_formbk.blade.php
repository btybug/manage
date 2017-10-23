<div class="row hidden">
    <div class="col-md-9">
        <!-- begin panel -->
        <div class="panel panel-default">
            <div class="panel-heading bg-black-darker text-white">Essentials</div>
            <div class="panel-body">
                <table width="100%">
                    <tr>
                        <td width="17%" height="50" valign="middle">Title</td>
                        <td width="83%" height="50"
                            valign="middle">{!! Form::text('title',null,['class'=>'form-control']) !!}</td>
                    </tr>
                    <tr>
                        <td width="17%" height="50" valign="middle">&nbsp;</td>
                        <td width="83%" height="50"
                            valign="middle">{!! Form::submit($submitButtonText, array('class' => 'btn btn-success')) !!}</td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- end panel -->
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading bg-black-darker text-white">Menu: Main Navigation</div>
            <div class="panel-body form-inline">
                <div class="form-group col-md-4">
                    <label for="menuname">Menu Name</label>
                    {!! Form::text('title',null,['class'=>'form-control','placeholder'=>'Main Navigation']) !!} </div>
                <div class="form-group col-md-4">
                    <label for="type">Type</label>
                    {!! Form::select('type', [ 'horizontal' => 'Horizontal', 'vertical' => 'Vertical' ], null, ['id' => 'menuTypes', 'class' => 'form-control']) !!}
                </div>

                <div class="form-group col-md-4">
                    <label for="template">Menu Template</label>
                    {!! Form::select('template', [ 'default' => 'Default' ], null, ['id' => 'template', 'class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row"></div>

<div class="row">
    <div class="col-md-12" data-role="previewMenu">
        <div class="panel panel-default">
            <div class="panel-heading bg-black-darker text-white">Menu Preview</div>
            <div class="panel-body">
                <div id="navbar" data-preview="load">
                    sss
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading bg-black-darker text-white">Menu Item</div>
            <div class="panel-body">
                <a href="javascript:;" data-action="newItem" class="btn btn-primary">Add New Item</a> {!! $data !!}
            </div>
        </div>
    </div>
    <div class="col-md-6 hide" id="new-menu-item">
        <form id="new-item-form">
            <input type="hidden" name="parent_id" value=""/>
            <div class="panel panel-default">
                <div class="panel-heading bg-black-darker text-white form-title"></div>
                <div class="panel-body form-horizontal">
                    <div class="form-group">
                        <label for="edittext" class="col-sm-3 control-label">Text</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edittext" placeholder="Text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="editclass" class="col-sm-3 control-label">Class</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="editclass" placeholder="Class name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edituserstatus" class="col-sm-3 control-label">User status</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="edituserstatus">
                                <option value="both">Both</option>
                                <option value="before-login">Before Login</option>
                                <option value="after-login">After login</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group hide userrole">
                        <label for="edituserrole" class="col-sm-3 control-label">User Role</label>
                        <div class="col-sm-9">
                            {!! Form::select('user_role', $roles, null, ['class' => 'form-control','id'=>'edituserrole']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="selectlink" class="col-sm-3 control-label">Link</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="selectlink">
                                <option value="corepage">Core page</option>
                                <option value="custompage">Custom page</option>
                                <option value="custom-link">Custom link</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group selectpage hide" data-selectpage="corepage">
                        <label for="editcorepage" class="col-sm-3 control-label">Core page</label>
                        <div class="col-sm-9">
                            {!! Form::select('editcorepage',$core_pages, null, ['class' => 'form-control','id'=>'editcorepage']) !!}
                        </div>
                    </div>
                    <div class="form-group selectpage hide" data-selectpage="custompage">
                        <label for="editcustompage" class="col-sm-3 control-label">Custom page</label>
                        <div class="col-sm-9">
                            {!! Form::select('editcustompage',$custpm_pages, null, ['class' => 'form-control','id'=>'editcustompage']) !!}
                        </div>
                    </div>
                    <div class="form-group selectpage hide" data-selectpage="custom-link">
                        <label for="editcustom-link" class="col-sm-3 control-label">Custom link</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="editcustom-link"
                                   placeholder="http://www.example.com/home">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="editopenNewtab"></label>
                        <div class=" col-sm-9">
                            <input type="checkbox" id="editopenNewtab"> Open in new Tab?
                        </div>
                    </div>
                    @include('create::menu.frontend._icon')
                    <p class="text-right p-r-15">
                        <button type="button" class="btn btn-success" data-action="update">Update</button>
                        <button type="button" class="btn btn-default" data-action="cancel">Cancel</button>
                    </p>
                </div>
            </div>
        </form>
    </div>
</div>

@section('CSS')
    {!! HTML::style('/public/css/menu.css?v=0.9') !!}
    {!! HTML::style('/public/css/page.css?v=0.13') !!}
@stop

@section('JS')
    {!! HTML::script('libs/bootbox/js/bootbox.min.js') !!}
    {!! HTML::script('libs/jqueryui/js/jquery-ui.min.js') !!}
    {!! HTML::script('libs/nestedSortable/jquery.mjs.nestedSortable.js') !!}
    {!! HTML::script('public/js/menu.js?v=0.03') !!}
@stop
