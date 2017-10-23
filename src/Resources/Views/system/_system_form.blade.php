<div class="col-sm-12  col-md-12">
    <div class="form-group">
        {!! Form::label('default_language',"Default Language",[])!!}
        {!! Form::select('default_language', [null=>'Please Select'] + $languages,(isset($system['default_language']))?$system['default_language']: Config::get('app.locale'),['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Language'])!!}
    </div>
    <div class="form-group">
        {!! Form::label('timezone_id',"Timezone",[])!!}
        {!! Form::select('timezone_id', [null=>'Please Select'] + $timezones,(isset($system['timezone_id']))?$system['timezone_id']: 'UTC',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Timezone'])!!}
    </div>
    <div class="form-group">
        {!! Form::label('direction',"Direction",[])!!}
        {!! Form::select('direction', ['ltr'=>'Left to Right',
            'rtl' => 'Right to Left'],(isset($system['direction']))?$system['direction']: 'ltr' ,['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Timezone'])!!}
    </div>
    <div class="form-group">
        {!! Form::label('error_display','Error Display',['class' => ' control-label labels error-label'])!!}
        <div class="">
            <div class="radio">
                <label class="radio_label labels">
                    {!! Form::radio('error_display', 1, (isset($system['error_display']) && $system['error_display']) ? 'checked' : '') !!}
                    True
                </label>
                <label class="radio_label labels">
                    {!! Form::radio('error_display', 0, (!isset($system['error_display']) || ($system['error_display'] == 0) ) ? 'checked' : '') !!}
                    False
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('date_format','Date format',['class' => 'control-label labels'])!!}
        {!! Form::select('date_format',[
            'l, d F Y' => date('l, d F Y'),
            'd F Y' => date('d F Y'),
            'd/m/Y' => date('d/m/Y'),
          'd.m.Y' => date('d.m.Y'),
          'd-m-Y' => date('d-m-Y'),
          'M-d-Y' => date('m-d-Y'),
            'Y/m/d' => date('Y/m/d'),
            'm / d' => date('m / d'),
            'd-M-y' => date('d-M-y'),
            'd, M y' => date('d, M y'),
            'd, M Y' => date('d, M Y'),
          ],(isset($system['date_format'])) ?$system['date_format'] : "d/m/Y",['class'=>'form-control','placeholder'=>'Enter Date Format'])!!}
        {{--<i class="help-block">Default is dd/mm/yyyy, see <a href="https://php.net/strftime">this</a> (parameters section) for more information.</i>--}}
    </div>
    <div class="form-group">
        {!! Form::label('time_format','Time format',['class' => 'control-label labels'])!!}
        <div class="">
            <div class="radio">
                <label>
                    {!! Form::radio('time_format', 'seconds', (isset($system['time_format']) && $system['time_format']== 'seconds') ? 'checked' : '') !!}
                    HH:MM:SS
                </label>
            </div>
            <div class="radio">
                <label>
                    {!! Form::radio('time_format', '24hrs', (isset($system['time_format']) && $system['time_format']== '24hrs') ? 'checked' : '') !!}
                    HH:MM 24 Hours
                </label>
            </div>
            <div class="radio">
                <label>
                    {!! Form::radio('time_format', '12hrs', (isset($system['time_format']) && $system['time_format']== '12hrs') ? 'checked' : '') !!}
                    HH:MM 12 Hours
                </label>
            </div>
        </div>
    </div>
    {{--<div class="form-group">--}}
    {{--{!! Form::label('installation_path','Install Path',['class' => 'col-sm-4 control-label'])!!}--}}
    {{--<div class="col-sm-8">--}}
    {{--<div class="radio">--}}
    {{--<label>--}}
    {{--{!! Form::radio('installation_path', 1, (config('config.installation_path')) ? 'checked' : '') !!} Enable--}}
    {{--</label>--}}
    {{--<label>--}}
    {{--{!! Form::radio('installation_path', 0, (!config('config.installation_path')) ? 'checked' : '') !!} Disable--}}
    {{--</label>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group">--}}
    {{--{!! Form::label('show_terms_and_conditions','Show T&C',['class' => 'col-sm-4 control-label'])!!}--}}
    {{--<div class="col-sm-8">--}}
    {{--<div class="radio">--}}
    {{--<label>--}}
    {{--{!! Form::radio('show_terms_and_conditions', 1, (config('config.show_terms_and_conditions')) ? 'checked' : '') !!} Yes--}}
    {{--</label>--}}
    {{--<label>--}}
    {{--{!! Form::radio('show_terms_and_conditions', 0, (!config('config.show_terms_and_conditions')) ? 'checked' : '') !!} No--}}
    {{--</label>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group">--}}
    {{--{!! Form::label('show_datetime_in_footer','Date Time in footer',['class' => 'col-sm-4 control-label'])!!}--}}
    {{--<div class="col-sm-8">--}}
    {{--<div class="radio">--}}
    {{--<label>--}}
    {{--{!! Form::radio('show_datetime_in_footer', 1, (config('config.show_datetime_in_footer')) ? 'checked' : '') !!} Yes--}}
    {{--</label>--}}
    {{--<label>--}}
    {{--{!! Form::radio('show_datetime_in_footer', 0, (!config('config.show_datetime_in_footer')) ? 'checked' : '') !!} No--}}
    {{--</label>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group">--}}
    {{--{!! Form::label('show_timezone_in_footer','Timezone in footer',['class' => 'col-sm-4 control-label'])!!}--}}
    {{--<div class="col-sm-8">--}}
    {{--<div class="radio">--}}
    {{--<label>--}}
    {{--{!! Form::radio('show_timezone_in_footer', 1, (config('config.show_timezone_in_footer')) ? 'checked' : '') !!} Yes--}}
    {{--</label>--}}
    {{--<label>--}}
    {{--{!! Form::radio('show_timezone_in_footer', 0, (!config('config.show_timezone_in_footer')) ? 'checked' : '') !!} No--}}
    {{--</label>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {!! Form::submit("Save",['class' => 'btn btn-primary']) !!}
</div>
<div class="clear"></div>


