@extends( 'layouts.admin' )
@section( 'content' )
    {!! Form::model($email,['class'=>'form-horizontal']) !!}
    <div class="row">
        <div class="col-xs-3">Title</div>
        <div class="col-xs-6">
            {!! Form::text('name',null,['class'=>'form-control']) !!}
        </div>
        <div class="col-xs-3"><input class="btn btn-success pull-right m-b-10 p-r-30 p-l-30" value="Save" type="submit">
        </div>

    </div>
    <div class="col-md-9 p-0">
        <div class="panel panel-default p-0" data-sortable-id="ui-typography-7">
            <div class="panel-heading bg-black-darker text-white">Email Content</div>
            <div class="panel-body p-5">
                <table class="table borderless m-0">
                    <tbody>
                    <tr>
                        <td width="15%">
                            <div class="p-5">From</div>
                        </td>
                        <td>
                            {!! Form::select('from_',
                            [
                            'info@avatarbugs.com'=>'Info',
                            'support@avatarbugs.com'=>'Support',
                            'admin@avatarbugs.com'=>'Admin',
                            'sales@avatarbugs.com'=>'Sales',
                            'tech@avatarbugs.com'=>'Technical Staff'
                            ],null,['class'=>'form-control']) !!}

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="p-5">To</div>
                        </td>
                        <td>
                            <div class="input-group">
                                {!! Form::text('to_',null,['class'=>'form-control hide tagit-hidden-field','data-tagit'=>'tagit']) !!}
                                <div class="input-group-addon addonNone" data-toggle="tooltip" data-placement="right"
                                     title=""
                                     data-original-title="administrator,manager,superadmin,user,Requested Email,Logged  User,Signup User,user submitted form">
                                    <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="p-5">Notify To</div>
                        </td>
                        <td>
                            <div class="input-group">
                                {!! Form::text('notify_to',null,['class'=>'form-control hide tagit-hidden-field','data-tagit'=>'tagit']) !!}

                                <div class="input-group-addon addonNone" data-toggle="tooltip" data-placement="right"
                                     title=""
                                     data-original-title="administrator,manager,superadmin,user,Requested Email,Logged  User,Signup User">
                                    <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="p-5">CC</div>
                        </td>
                        <td>
                            <div class="input-group">
                                {!! Form::text('cc',null,['class'=>'form-control hide tagit-hidden-field','data-tagit'=>'tagit']) !!}
                                <div class="input-group-addon addonNone" data-toggle="tooltip" data-placement="right"
                                     title=""
                                     data-original-title="administrator,manager,superadmin,user,Requested Email,Logged  User,Signup User">
                                    <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="p-5">BCC</div>
                        </td>
                        <td>
                            <div class="input-group">
                                {!! Form::text('bcc',null,['class'=>'form-control hide tagit-hidden-field','data-tagit'=>'tagit']) !!}
                                <div class="input-group-addon addonNone" data-toggle="tooltip" data-placement="right"
                                     title=""
                                     data-original-title="administrator,manager,superadmin,user,Requested Email,Logged  User,Signup User">
                                    <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="p-5">Reply To</div>
                        </td>
                        <td>
                            {!! Form::select('replyto',
                        [
                        'info@avatarbugs.com'=>'Info',
                        'support@avatarbugs.com'=>'Support',
                        'admin@avatarbugs.com'=>'Admin',
                        'sales@avatarbugs.com'=>'Sales',
                        'tech@avatarbugs.com'=>'Technical Staff'
                        ],null,['class'=>'form-control']) !!}
                        </td>
                    </tr>


                    <tr>
                        <td>
                            <div class="p-5">Subject</div>
                        </td>
                        <td>
                            {!! Form::text('subject',null,['class'=>'form-control']) !!}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="p-5">Attachment</div>
                        </td>
                        <td>
                            <button class="btn btn-default" type="button" data-role="browseMediabutton">Browse Media
                            </button>
                            <span class="m-l-10"></span>
                            {!! Form::text('attachment',null,['class'=>'form-control hide tagit-hidden-field','data-tagit'=>'tagit']) !!}
                        </td>
                    </tr>


                    <tr id="editor">
                        <td valign="top">
                            <div class="p-5">Content</div>
                        </td>
                        <td>
                            {!! Form::textarea('content',null,['id'=>'contentEditor','aria-hidden'=>true]) !!}
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-3 p-0 p-l-5">
        <div class="panel panel-default p-0" data-sortable-id="ui-typography-7">
            <div class="panel-heading bg-black-darker text-white">Content</div>
            <div class="panel-body p-5">
                <table class="table borderless m-0">
                    <tbody>
                    <tr>
                        <td>
                            <div class="p-b-5">Content Type</div>
                            {!! Form::select('content_type',
                [
                'iwysiwyg'=>'WYSIWYG',
                'template'=>'Template',
                ],null,['class'=>'form-control']) !!}

                        </td>
                    </tr>
                    <tr class="template">
                        <td>
                            <div class="p-b-5">Templates</div>
                            <select class="form-control" id="template" name="template_id"></select></td>
                    </tr>
                    <tr class="template-var" style="display:none">
                        <td>
                            <div class="p-b-5">Variations</div>
                            <select class="form-control" id="variation_id" name="variation_id"></select></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel panel-default p-0" data-sortable-id="ui-typography-7">
            <div class="panel-heading bg-black-darker text-white">Event and Time</div>
            <div class="panel-body p-5">
                <table class="table borderless m-0">

                    <tbody>
                    <tr class="select-trigger-td">
                        <td>
                            <div class="p-b-5">Event / Trigger</div>
                            {!! Form::select('event_code',[
                                'auth.login' => 'User Login',
                                'auth.logout' => 'User Logout',
                                'user.register' => 'User Register',
                                'forgot.password' => 'Forgot Password',
                                'account.activated' => 'Account Activate',
                                'CustomFormSubmittedEvent' => 'Form Was Submit',
                                'form_submited' => 'Form Submited',
                            ], null, ['id' => 'event_trigger','class' => 'form-control']) !!}
                        </td>
                    </tr>

                    @if($email->event_code == 'form_submited')
                        @include('manage::emails._partial.form_lists')
                    @endif

                    <tr>
                        <td>
                            <div class="p-b-5">When</div>
                            {!! Form::select('when_',[
                                'immediate' => "Immediate",
                                'custom_time' => 'Custom Time'
                            ],null,['class' => 'form-control','data-change' => 'afterday' ,'id' => 'when_']) !!}

                        </td>
                    </tr>
                    <tr data-container="afterday" class="hide">
                        <td>
                            <div class="p-b-5">After Days</div>
                            <select class="form-control" id="afterday" data-change="settime" name="custom_days">
                                <option value="1">1 Day</option>
                                <option value="3">3 Days</option>
                                <option value="5">5 Days</option>
                                <option value="10">10 Days</option>
                                <option value="15">15 Days</option>
                                <option value="30">30 Days</option>
                                <option value="0" selected="selected">Custom Date</option>
                            </select>
                        </td>
                    </tr>
                    <tr data-container="settime" class="hide">
                        <td>
                            <div class="p-b-5">Select Date</div>
                            <div class="input-group date" data-actions="Timercalendar">
                                <input name="custom_time" class="form-control" value="" type="text">
                                <span class="input-group-addon"> <i class="fa fa-calendar"
                                                                    aria-hidden="true"></i> </span></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel panel-default p-0" data-sortable-id="ui-typography-7">
            <div class="panel-heading bg-black-darker text-white">Available Codes</div>
            <div class="panel-body p-5">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#general_shortcodes">General</a></li>
                    <li><a data-toggle="tab" href="#specific_shortcodes">Specific</a></li>
                </ul>
                <div class="tab-content">
                    <div id="general_shortcodes" class="tab-pane fade in active">
                        <table class="table borderless m-0">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="sc-item m-b-5">[general key=logo]</div>
                                    <div class="sc-item m-b-5">[general key=site_name]</div>

                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="specific_shortcodes" class="tab-pane fade">
                        <h3>Specific shortcodes here</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

@stop
@section( 'CSS' )
    {!!HTML::style( '/resources/assets/js/tag-it/css/jquery.tagit.css' ) !!}
    <style>
        .input-group-addon.addonNone {
            background: none;
            border: 0;
            box-shadow: none
        }
    </style>
@stop
@section( 'JS' )
    {!! HTML::script('js/tinymice/tinymce.min.js') !!}
    {!! HTML::script('js/tag-it/js/tag-it.js') !!}
    <script>
        tinymce.init({
            selector: 'textarea#contentEditor',
            height: 500,
            theme: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools'
            ],
            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons',
            image_advtab: true,

        });

        $(function () {

            var tagdatasorce = 'administrator,manager,superadmin,user,Requested Email,Logged  User,Signup User';
            $('[data-tagit="tagit"]').each(function () {
                var getExt = tagdatasorce.split(',');
                $(this).tagit({
                    availableTags: getExt

                });

            })
            $('[data-toggle="tooltip"]').tooltip()
            var formLists = function (data) {

                $(data.html).insertAfter($('.select-trigger-td'));
            }
            $('#event_trigger').on('change', function () {
                $('body').find('.appendet-forms-lists').remove();
                if ($(this).val() == 'form_submited') {
                    var data = {};
                    postAjax('/admin/manage/emails/get-forms-lists', data, formLists);
                }
            });

            $('body').on('change', 'select[name="trigger_on_form"]', function () {
                if ($(this).val() != '0') {
                    $.ajax({
                        url: "{!! url('/admin/manage/emails/get-forms-shortcodes') !!}",
                        type: 'POST',
                        data: {
                            form_slug: $(this).val()
                        },
                        headers: {
                            'X-CSRF-TOKEN': $("input[name='_token']").val()
                        }
                    }).done(function (data) {
                        $('#specific_shortcodes').html(data.html);
                    }).fail(function () {
                        alert('Could not load shortcodes. Please try again.');
                    });
                }

            });

            var event_code = $('#event_trigger').val();
            if (event_code == 'form_submited') {
                var form_slug = $('select[name="trigger_on_form"]').val();

                if (form_slug != '0') {
                    $.ajax({
                        url: "{!! url('/admin/manage/emails/get-forms-shortcodes') !!}",
                        type: 'POST',
                        data: {
                            form_slug: form_slug
                        },
                        headers: {
                            'X-CSRF-TOKEN': $("input[name='_token']").val()
                        }
                    }).done(function (data) {
                        $('#specific_shortcodes').html(data.html);
                    }).fail(function () {
                        alert('Could not load shortcodes. Please try again.');
                    });
                }

            }
        });

        $('body').on('click', ".sc-item", function () {
            tinymce.activeEditor.execCommand('mceInsertContent', false, $(this).text());
        });

    </script>

@stop