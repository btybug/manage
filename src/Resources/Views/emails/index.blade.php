@extends( 'cms::layouts.mTabs', [ 'index' => 'manage_emails' ] )
@section( 'tab' )
    <div class="container-fluid p-0 m-t-10">
        <div class="col-md-3 p-l-0">
            <div class="panel panel-default p-0">
                <div class="panel-heading bg-black-darker text-white">Email Groups<a data-toggle="collapse"
                                                                                     href="#addnewGroup"
                                                                                     class="btn btn-default btn-xs pull-right collapsed"
                                                                                     aria-expanded="false"><i
                                class="fa fa-plus" aria-hidden="true"></i></a>
                </div>
                <div class="panel-body">
                    <div id="addnewGroup" class="posrelative collapse" aria-expanded="false" style="height: 0px;">
                        <div class="loadinanimation hide"></div>
                        <div class="row">
                            <div class="form-group col-xs-8 col-sm-8 p-0 p-r-5">
                                <input class="form-control" placeholder="Add New Group" data-selector="newgroup"
                                       type="text">
                            </div>
                            <div class="form-group col-xs-4 col-sm-4 p-0">
                                <button class="btn btn-primary btn-block p-l-0 p-r-0" type="button"
                                        data-action="saveNewGroup">save
                                </button>
                            </div>
                        </div>
                    </div>
                    <ul class="list-group source listwithlink" data-role="grouplist">
                        {{--<a data-href="{!! url('/admin/users/roles/delete') !!}"--}}
                        {{--data-key="{!! $role->id !!}" data-type="Role {{ $role->name }}" class="delete-button btn btn-danger"><i--}}
                        {{--class="fa fa-trash-o f-s-14 "></i></a>--}}
                        @foreach($groups as $group)
                            <li class="{!! ($group->id==$id)?'active':'' !!} list-group-item"
                                data-id="{!! $group->id !!}"><a
                                        href="{!! url('/admin/manage/emails',$group->id) !!}"> {!! $group->name !!} </a><span
                                        class="listtool"><a href="#" class="btn btn-default" data-action="editGroup"
                                                            data-id="4" data-title="common"><i class="fa fa-pencil"
                                                                                               aria-hidden="true"></i></a> <a
                                            href="#" class="btn btn-default" data-action="deleteGroup" data-id="4"><i
                                                class="fa fa-trash-o" aria-hidden="true"></i></a></span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9 p-0">
            <div class="m-0">
                <div id="tpl-table_wrapper" class="form-inline dt-bootstrap">
                    <table class="table table-bordered" id="tpl-table">
                        <thead>
                        <tr class="bg-black-darker text-white">
                            <th> Title</th>
                            <th> Subject</th>
                            <th> Receiver</th>
                            <th> Updated</th>
                            <th width="15%"> Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <td><input type="text" class="form-control width-full" placeholder="Title"/></td>
                            <td><input type="text" class="form-control width-full" placeholder="Subject"/></td>
                            <td><input type="text" class="form-control width-full" placeholder="Receiver"/></td>
                            <td><input type="text" class="form-control width-full" placeholder="Updated"/></td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>

                </div>
            </div>

        </div>
    </div>

    <div class="modal fade " id="addEmail" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Add New Email</h4>
                </div>
                <form method="POST" action="#" accept-charset="UTF-8" class="form-horizontal">
                    <input name="group_id" value="4" type="hidden">
                    <input class="emailID" name="email_id" value="" type="hidden">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10"><input class="form-control emailName" data-inval="emailname"
                                                          placeholder="Name" name="name" value="" type="text">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" data-btnrole="saveemail">Save Email</button>
                        </div>
                    </div>
                </form>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>


@stop
@include('cms::_partials.delete_modal')
@include('manage::emails._partial.datatable')
@section( 'CSS' )
    {!!HTML::style( 'css/themes-settings.css' ) !!}
@stop

@section( 'JS' )
    <script>

        $('body').on('click', '.add-new-email', function () {
            $('#addEmail form')[0].reset();
            // $('#addEmail form').attr('action','/admin/settings/add-email');
            $('#addEmail').modal();
        });

        $(function () {
            $('#submit_btn').hide();

            table = $('#tpl-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 1000,
                ajax: '/admin/manage/emails/data/{{$id}}',
                dom: 'Bfrtip',
                buttons: [
                    'colvis', 'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'subject', name: 'subject'},
                    {data: 'to_', name: 'to_'},
                    {data: 'updated_at', name: 'updated_at'},
                    {data: 'action', name: 'action', orderable: false}
                ]
            });

            table.columns().every(function () {
                var string = this;
                $("input", this.footer()).on("keyup change", function () {
                    if (string.search() !== this.value) {
                        string.search(this.value).draw();
                    }
                });
            });
            $("div.dt-buttons").html('<button class="btn btn-info add-new-email"><i class="fa fa-plus"></i>&nbsp; Add New Email</button>');


            $('[data-action="saveNewGroup"]').click(function (e) {
                e.preventDefault()
                var getvalue = $('[data-selector="newgroup"]').val()
                var getEdit = $(this).attr('data-edit');
                if (getvalue == '') {
                    $('[data-selector="newgroup"]').focus()
                    return false;
                }
                $('.loadinanimation').removeClass('hide');
                if (getEdit) {
                    var id = $(this).data('edit')
                    $('[data-role="grouplist"] li.editActive > a').text(getvalue)
                    $('[data-role="grouplist"] li.editActive [data-action="editGroup"]').data('title', getvalue)
                    var afterDone = function () {
                        $('[data-role="grouplist"] li').removeClass('editActive');
                        $("#addnewGroup").collapse("hide");
                        $('.loadinanimation').addClass('hide');
                    }
                    postAjax('/admin/settings/email/editgroup', {'group': getvalue, 'id': id}, afterDone);
                    $('[data-action="saveNewGroup"]').removeAttr('data-edit');
                } else {
                    var afterDone = function (d) {
                        if (!d.error) {
                            if (d.html) {
                                $('[data-role="grouplist"]').append(d.html);
                                $("#addnewGroup").collapse("hide");
                                $('.loadinanimation').addClass('hide');
                            }
                        } else {
                            var message = d;

                            if (d.message) {
                                message = '';
                                if (typeof d.message == 'object') {
                                    $.each(d.message, function (key, val) {
                                        message += '<p>' + key + ' :- ' + val + '</p>'
                                    })
                                } else {

                                    message = d.message
                                }
                            }

                            bootbox.alert(message);
                        }
                        var hItem = '<li class="list-group-item"><a href="/admin/settings/email/custom/' + d.id + '">  ' + d.name + ' </a><span class="listtool"><a href="#" class="btn btn-default" data-action="editGroup" data-id="' + d.id + '" data-title="' + d.name + '"><i class="fa fa-pencil" aria-hidden="true"></i></a> <a href="#" class="btn btn-default" data-action="deleteGroup" data-id="' + d.id + '"><i class="fa fa-trash-o" aria-hidden="true"></i></a></span></li>';

                    }
                    postAjax('/admin/manage/emails/create-group', {'name': getvalue}, afterDone);
                }

            })


            $('[href="#addnewGroup"]').click(function (e) {
                e.preventDefault()
                $('.loadinanimation').addClass('hide');
                $('[data-selector="newgroup"]').val('')
                $('[data-action="saveNewGroup"]').removeAttr('data-edit');
            })

            $('body').on('click', '[data-action="editGroup"]', function (e) {
                e.preventDefault()
                $("#addnewGroup").collapse("show");
                $('[data-role="grouplist"] li').removeClass('editActive');
                $(this).closest('li').addClass('editActive')
                $('.loadinanimation').addClass('hide');
                $('[data-action="saveNewGroup"]').attr('data-edit', $(this).data('id'))
                $('[data-selector="newgroup"]').val($(this).data('title'))
            })

            $('body').on('click', '[data-btnrole="saveemail"]', function (e) {
                e.preventDefault()
                var data = {
                    'group_id': $('[data-role="grouplist"] li.active').data('id'),
                    name: $('[data-inval="emailname"]').val()
                }
                $('#addEmail').modal('hide')
                var alferdone = function (d) {
                    if (!d.error) {
                        table.ajax.reload();
                    } else {
                        var message = d;

                        if (d.message) {
                            message = '';
                            if (typeof d.message == 'object') {
                                $.each(d.message, function (key, val) {
                                    message += '<p>' + key + ' :- ' + val + '</p>'
                                })
                            } else {
                                message = d.message
                            }
                        }

                        bootbox.alert(message);
                    }
                }
                postAjax('/admin/manage/emails/create-email', data, alferdone);
            })


        });

    </script>
@stop