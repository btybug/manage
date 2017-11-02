@extends('btybug::layouts.mTabs',['index'=>'manage_emails'])
@section('tab')
    <div class="row m-t-8">
        <div class="col-sm-8">
            <div class="panel panel-default p-0">
                <div class="panel-heading bg-black-darker text-white">Email Settings</div>
                <div class="panel-body">
                    {!! Form::model($model) !!}
                    <table class="table borderless m-0">
                        <tbody>
                        <tr>
                            <td width="30%">
                                <div class="p-t-5">Email Driver</div>
                            </td>
                            <td>
                                {!! Form::select('driver',['smtp'=>'SMTP','mail'=>'Mail'],null,['class'=>'form-control']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="p-t-5">Host</div>
                            </td>
                            <td>
                                {!! Form::text('host',null,['class'=>'form-control']) !!}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="p-t-5">Port</div>
                            </td>
                            <td>
                                {!! Form::text('port',null,['class'=>'form-control','placeholder'=>'25/587/465']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="p-t-5">From Email</div>
                            </td>
                            <td>
                                {!! Form::text('from_address',null,['class'=>'form-control']) !!}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="p-t-5">From Name</div>
                            </td>
                            <td>
                                {!! Form::text('from_name',null,['class'=>'form-control','placeholder'=>'Jon']) !!}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="p-t-5">SMTP User Name</div>
                            </td>
                            <td>
                                {!! Form::text('username',null,['class'=>'form-control','placeholder'=>'SMTP server user name']) !!}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="p-t-5">SMTP User Password</div>
                            </td>
                            <td>
                                <input class="form-control" name="password" placeholder="SMTP server Password"
                                       value="{!! $model['password'] or null !!}" type="password">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input class="btn btn-success  p-r-30 p-l-30" value="Save" type="submit">
                            </td>
                        </tr>

                        </tbody>
                    </table>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="panel panel-default p-0">
                <div class="panel-heading bg-black-darker text-white">Confirm Settings</div>
                <div class="panel-body">

                    <table class="table borderless m-0">
                        <tbody>
                        <tr>


                            <td colspan="2">
                                @if(!isset($model['is_invalid']) || $model['is_invalid']=='2' )
                                    <div class="led-box">
                                        <div class="led-yellow"></div>
                                    </div>
                                    <p class="led-message">settings are not checked</p>
                                @elseif($model['is_invalid']=='1')

                                    <div class="led-box">
                                        <div class="led-red"></div>
                                    </div>
                                    <p class="led-message">settings are invalid</p>
                                @elseif((int)$model['is_invalid']==0)
                                    <div class="led-box">
                                        <div class="led-green"></div>
                                    </div>
                                    <p class="led-message">settings are valid</p>
                                @endif
                            </td>

                        </tr>
                        @if(!isset($model['is_invalid']) || $model['is_invalid']!=0 )
                            <tr class="deletable">
                                <td width="35%">
                                    <div class="p-t-5">Email to send test</div>
                                </td>
                                <td>
                                    {!! Form::email('email',null,['class'=>'form-control email-input']) !!}
                                </td>
                            </tr>
                            <tr class="deletable">
                                <td></td>
                                <td>
                                    <input class="btn btn-success  p-r-30 p-l-30 check-email-settings"
                                           value="Check" type="button"></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop
@section('CSS')
    <style>
        .container {
            background-size: cover;
            background: rgb(226, 226, 226); /* Old browsers */
            background: -moz-linear-gradient(top, rgba(226, 226, 226, 1) 0%, rgba(219, 219, 219, 1) 50%, rgba(209, 209, 209, 1) 51%, rgba(254, 254, 254, 1) 100%); /* FF3.6+ */
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(226, 226, 226, 1)), color-stop(50%, rgba(219, 219, 219, 1)), color-stop(51%, rgba(209, 209, 209, 1)), color-stop(100%, rgba(254, 254, 254, 1))); /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(top, rgba(226, 226, 226, 1) 0%, rgba(219, 219, 219, 1) 50%, rgba(209, 209, 209, 1) 51%, rgba(254, 254, 254, 1) 100%); /* Chrome10+,Safari5.1+ */
            background: -o-linear-gradient(top, rgba(226, 226, 226, 1) 0%, rgba(219, 219, 219, 1) 50%, rgba(209, 209, 209, 1) 51%, rgba(254, 254, 254, 1) 100%); /* Opera 11.10+ */
            background: -ms-linear-gradient(top, rgba(226, 226, 226, 1) 0%, rgba(219, 219, 219, 1) 50%, rgba(209, 209, 209, 1) 51%, rgba(254, 254, 254, 1) 100%); /* IE10+ */
            background: linear-gradient(to bottom, rgba(226, 226, 226, 1) 0%, rgba(219, 219, 219, 1) 50%, rgba(209, 209, 209, 1) 51%, rgba(254, 254, 254, 1) 100%); /* W3C */
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#e2e2e2', endColorstr='#fefefe', GradientType=0); /* IE6-9 */
            padding: 20px;
        }

        .led-box {
            height: 30px;
            width: 25%;
            margin: 10px 0;
            float: left;
        }

        .led-box p {
            font-size: 12px;
            text-align: center;
            margin: 1em;
        }

        .led-red {
            margin: 0 auto;
            width: 24px;
            height: 24px;
            background-color: #F00;
            border-radius: 50%;
            box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #441313 0 -1px 9px, rgba(255, 0, 0, 0.5) 0 2px 12px;
            -webkit-animation: blinkRed 0.5s infinite;
            -moz-animation: blinkRed 0.5s infinite;
            -ms-animation: blinkRed 0.5s infinite;
            -o-animation: blinkRed 0.5s infinite;
            animation: blinkRed 0.5s infinite;
        }

        @-webkit-keyframes blinkRed {
            from {
                background-color: #F00;
            }
            50% {
                background-color: #A00;
                box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #441313 0 -1px 9px, rgba(255, 0, 0, 0.5) 0 2px 0;
            }
            to {
                background-color: #F00;
            }
        }

        @-moz-keyframes blinkRed {
            from {
                background-color: #F00;
            }
            50% {
                background-color: #A00;
                box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #441313 0 -1px 9px, rgba(255, 0, 0, 0.5) 0 2px 0;
            }
            to {
                background-color: #F00;
            }
        }

        @-ms-keyframes blinkRed {

            from {
                background-color: #F00;
            }

            50% {
                background-color: #A00;
                box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #441313 0 -1px 9px, rgba(255, 0, 0, 0.5) 0 2px 0;
            }
            to {
                background-color: #F00;
            }

        }

        @-o-keyframes blinkRed {
            from {
                background-color: #F00;
            }
            50% {
                background-color: #A00;
                box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #441313 0 -1px 9px, rgba(255, 0, 0, 0.5) 0 2px 0;
            }
            to {
                background-color: #F00;
            }
        }

        @keyframes blinkRed {
            from {
                background-color: #F00;
            }
            50% {
                background-color: #A00;
                box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #441313 0 -1px 9px, rgba(255, 0, 0, 0.5) 0 2px 0;
            }
            to {
                background-color: #F00;
            }
        }

        .led-yellow {
            margin: 0 auto;
            width: 24px;
            height: 24px;
            background-color: #FF0;
            border-radius: 50%;
            box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #808002 0 -1px 9px, #FF0 0 2px 12px;
            -webkit-animation: blinkYellow 1s infinite;
            -moz-animation: blinkYellow 1s infinite;
            -ms-animation: blinkYellow 1s infinite;
            -o-animation: blinkYellow 1s infinite;
            animation: blinkYellow 1s infinite;
        }

        @-webkit-keyframes blinkYellow {
            from {
                background-color: #FF0;
            }
            50% {
                background-color: #AA0;
                box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #808002 0 -1px 9px, #FF0 0 2px 0;
            }
            to {
                background-color: #FF0;
            }
        }

        @-moz-keyframes blinkYellow {
            from {
                background-color: #FF0;
            }
            50% {
                background-color: #AA0;
                box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #808002 0 -1px 9px, #FF0 0 2px 0;
            }
            to {
                background-color: #FF0;
            }
        }

        @-ms-keyframes blinkYellow {

            from {
                background-color: #FF0;
            }

            50% {
                background-color: #AA0;
                box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #808002 0 -1px 9px, #FF0 0 2px 0;
            }
            to {
                background-color: #FF0;
            }

        }

        @-o-keyframes blinkYellow {
            from {
                background-color: #FF0;
            }
            50% {
                background-color: #AA0;
                box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #808002 0 -1px 9px, #FF0 0 2px 0;
            }
            to {
                background-color: #FF0;
            }
        }

        @keyframes blinkYellow {
            from {
                background-color: #FF0;
            }
            50% {
                background-color: #AA0;
                box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #808002 0 -1px 9px, #FF0 0 2px 0;
            }
            to {
                background-color: #FF0;
            }
        }

        .led-green {
            margin: 0 auto;
            width: 24px;
            height: 24px;
            background-color: #ABFF00;
            border-radius: 50%;
            box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #304701 0 -1px 9px, #89FF00 0 2px 12px;
        }

        .led-blue {
            margin: 0 auto;
            width: 24px;
            height: 24px;
            background-color: #24E0FF;
            border-radius: 50%;
            box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #006 0 -1px 9px, #3F8CFF 0 2px 14px;
        }
    </style>
@stop

@section('JS')
    <script>
        $(function () {
            $('.check-email-settings').on('click', function () {
                var data = {'email': $('.email-input').val()};
                var callBack = function (data) {
                    switch (data.code) {
                        case 0:
                            $('.led-box').html('<div class="led-green"></div>');
                            $('.led-message').text('settings are valid');
                            $('.deletable').remove();
                            break;
                        case 1:
                            $('.led-box').html('<div class="led-red"></div>');
                            $('.led-message').text('settings are invalid');
                            break;
                    }
                    ;
                }
                postAjax('/admin/manage/emails/check-email-settings', data, callBack);
            })
        })
    </script>
@stop
