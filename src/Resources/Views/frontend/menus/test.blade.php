@extends('btybug::layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2>Menu</h2>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>type</th>
                    <th>name</th>
                    <th>Membership</th>
                </tr>
                </thead>
                <tbody id="form_engine">
                <tr>
                    <td class="col-md-2">
                        <select name="type" class="form-control">
                            <option>Select Type</option>
                            <option value="ver">Vertical</option>
                            <option value="hor">horizontal</option>
                        </select>
                    </td>
                    <td class="col-md-8"><input type="text" name="name" class="form-control"/></td>
                    <td class="col-md-2"><select name="group" class="form-control">
                            <option value=""></option>
                        </select></td>

                </tbody>
            </table>
        </div>

    </div>
    <div class="row">
        <div class="col-md-2 menu_childs">

            <ol id="sortable1" class="droptrue">
                @foreach($items as $item)
                    @if(isset($item->custom_link) and !empty($item->custom_link))
                        <li class="ui-state-default menu_items" id="{!! $item->id !!}">
                            <div><span class="{!! $item->icon !!}"></span>{!! $item->title !!}<i
                                        class="fa fa-cog item_settings" style="float: right"></i></div>
                        </li>
                    @endif
                @endforeach
            </ol>
        </div>
        <div class="col-md-8">
            <ol id="sortable2" class="dropfalse">

            </ol>
        </div>
        <div class="col-md-2">
            <ol id="sortable3" class="droptrue">
                @foreach($items as $item)
                    @if(isset($item->custom_link) and empty($item->custom_link))
                        <li class="ui-state-default menu_items  parent_class" id="{!! $item->id !!}">
                            <div><span class="{!! $item->icon !!}"></span>{!! $item->title !!}<i
                                        class="fa fa-cog item_settings" style="float: right"></i></div>
                        </li>
                    @endif
                @endforeach
            </ol>

        </div>
        <div>

            <textarea data-export="json"></textarea>
            <pre id="toHierarchyOutput"></pre>

            @stop
            @section('CSS')
                <style>
                    #sortable1, #sortable2, #sortable3 {
                        border: 1px solid #eee;
                        min-height: 300px;
                        list-style-type: none;
                        margin: 0;
                        padding: 5px 0 0 0;
                        float: left;
                    }

                    #sortable2 {
                        width: 100%;
                        background: #dff0d8;
                    }

                    #sortable1 li, #sortable2 li, #sortable3 li {
                        margin: 0 5px 10px 5px;
                        padding: 5px;
                        width: 95%;
                    }

                    .parent_class {
                        background: #5cb85c;
                    }

                    .item_settings:hover {
                        color: #ef9d0c;
                    }
                </style>
            @stop

            @section('JS')
                {!! HTML::script('libs/nestedSortable/jquery.mjs.nestedSortable.js') !!}

                <script>


                    $(function () {

                        function retunjson(selector) {
                            var data = []
                            selector.each(function (index, element) {
                                var getdetail = {};
                                if ($(this).attr('id')) {
                                    getdetail['id'] = $(this).attr('id')
                                }
                                if ($(this).children('ol').is('ol')) {
                                    getdetail['children'] = retunjson($(this).children('ol').children('li'))
                                }
                                if (getdetail) {
                                    data.push(getdetail);
                                }
                            });
                            return data;

                        }

                        function exportjson() {
                            var hiered = retunjson($('#sortable2 > li'));
                            $('[data-export="json"]').val(JSON.stringify(hiered))
                        }

                        $('#sortable2').nestedSortable({
                            handle: 'div',
                            items: 'li',
                            toleranceElement: '> div',
                            update: function (event, ui) {
                                exportjson()

                            }
                        });

//                        $("#sortable1,#sortable4,#sortable").sortable({
//                            connectWith: ".connectedSortable"
//                        }).disableSelection();

                        $("#sortable").css({
                            "min-height": '300px'
                        })


                        $("ol.droptrue").sortable({
                            connectWith: "ol"
                        });

                        $("ol.dropfalse").sortable({
                            connectWith: "ol",
                            dropOnEmpty: true

                        });


                    });
                </script>

@stop
