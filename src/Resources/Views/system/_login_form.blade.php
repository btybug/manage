<div class="form-group">
    {!! Form::label('login_timeout','Login Timeout',[])!!}
    {!! Form::input('text','login_timeout',(isset($system['login_timeout']))?$system['login_timeout']: Config::get('session.lifetime'),['class'=>'form-control','placeholder'=>'Enter Login Timeout'])!!}
    <div class="help-block">(In minutes)</div>
</div>

<div class="form-group">

    {!! Form::label('enable_registration','Enable Registration',['class' => 'control-label labels'])!!}
    <div class="">
        <div class="radio">
            <label class="radio_label">
                {!! Form::radio('enable_registration', 1, (isset($system['enable_registration']) && $system['enable_registration']) ? 'checked' : '',['class' =>"enable_registration"]) !!}
                Yes
            </label>
            <label class="radio_label">
                {!! Form::radio('enable_registration', 0, (!isset($system['enable_registration']) || ($system['enable_registration'] == 0) ) ? 'checked' : '',['class' =>"enable_registration"]) !!}
                No
            </label>
        </div>
    </div>
</div>
<div class="form-group">
    @if(isset($system['enable_registration']) && $system['enable_registration'] && isset($system['default_frontend_role']) && $system['default_frontend_role'])
        <div class="email-activation-div">
            {!! Form::label('default_frontend_role','Default role',['class' => 'control-label labels'])!!}
            {!! Form::select('default_frontend_role', \Btybug\User\Models\Roles::getFrontendRoles(),(isset($system['default_frontend_role']))?$system['default_frontend_role']:null,['class'=>'form-control'])!!}
        </div>
    @else
        <div class="hidden email-activation-div">
            {!! Form::label('default_frontend_role','Default role',['class' => 'control-label labels'])!!}
            {!! Form::select('default_frontend_role',\Btybug\User\Models\Roles::getFrontendRoles(),(isset($system['default_frontend_role']))?$system['default_frontend_role']: null,['class'=>'form-control'])!!}
        </div>
    @endif

    @if(isset($system['enable_registration']) && $system['enable_registration'] && isset($system['default_user_status']) && $system['default_user_status'])
        <div class="email-activation-div">
            {!! Form::label('default_user_status','Default status',['class' => 'control-label labels'])!!}
            {!! Form::select('default_user_status', \Btybug\User\Models\Status::pluck('name', 'id'),(isset($system['default_user_status']))?$system['default_user_status']:null,['class'=>'form-control'])!!}
        </div>
    @else
        <div class="hidden email-activation-div">
            {!! Form::label('default_user_status','Default status',['class' => 'control-label labels'])!!}
            {!! Form::select('default_user_status',\Btybug\User\Models\Status::pluck('name', 'id'),(isset($system['default_user_status']))?$system['default_user_status']: null,['class'=>'form-control'])!!}
        </div>
    @endif

</div>

{{--<div class="form-group show-member-access {{ (isset($system['enable_registration']) && $system['enable_registration']) ? 'show' : 'hide' }}">--}}
{{--{!! Form::label('enable_member_access','Enable Member Access',['class' => 'control-label labels'])!!}--}}
{{--<div class="">--}}
{{--{!! Form::hidden('enable_member_access',0) !!}--}}
{{--{!! Form::checkbox('enable_member_access', 1, (isset($system['enable_member_access']) && $system['enable_member_access']) ? 'checked' : '',['class' =>"enable_member_access"]) !!}--}}
{{--</div>--}}
{{--</div>--}}

<div class="form-group">
    {!! Form::label('browser_close','Session end on Browser close',['class' => 'control-label labels'])!!}
    <div class="">
        <div class="radio">
            <label class="radio_label">
                {!! Form::radio('browser_close', 1, (isset($system['browser_close']) && $system['browser_close']) ? 'checked' : '') !!}
                Yes
            </label>
            <label class="radio_label">
                {!! Form::radio('browser_close', 0, (!isset($system['browser_close']) || ($system['browser_close'] == 0) ) ? 'checked' : '') !!}
                No
            </label>
        </div>
    </div>
</div>

{{--<div class="form-group">--}}
{{--{!! Form::label('tnc_on_register','Terms & Condition on Registration',['class' => 'col-sm-6 control-label'])!!}--}}
{{--<div class="col-sm-6">--}}
{{--<div class="radio">--}}
{{--<label>--}}
{{--{!! Form::radio('tnc_on_register', 1, (config('config.tnc_on_register')) ? 'checked' : '') !!} Yes--}}
{{--</label>--}}
{{--<label>--}}
{{--{!! Form::radio('tnc_on_register', 0, (!config('config.tnc_on_register')) ? 'checked' : '') !!} No--}}
{{--</label>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{!! Form::submit(isset($buttonText) ? $buttonText : "Save",['class' => 'btn btn-primary']) !!}
<div class="clear"></div>
