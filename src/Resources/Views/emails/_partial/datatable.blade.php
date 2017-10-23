@push('css')

    {!! HTML::style('libs/datatable/css/jquery.dataTables.min.css') !!}
    {!! HTML::style('libs/datatable/css/dataTables.bootstrap.min.css') !!}
    {!! HTML::style('libs/datatable/extensions/Buttons/css/buttons.dataTables.min.css') !!}
@endpush
@push('javascript')
    {!! HTML::script('libs/datatable/js/jquery.dataTables.min.js') !!}
    {!! HTML::script('libs/datatable/js/dataTables.bootstrap.min.js') !!}

    {!! HTML::script('libs/datatable/extensions/Buttons/js/dataTables.buttons.min.js') !!}

    {!! HTML::script('libs/datatable/extensions/Buttons/js/buttons.flash.min.js') !!}
    {!! HTML::script('libs/datatable/extensions/Buttons/js/buttons.html5.min.js') !!}
    {!! HTML::script('libs/datatable/extensions/Buttons/js/buttons.print.min.js') !!}
    {!! HTML::script('libs/datatable/extensions/Buttons/js/buttons.colVis.min.js') !!}

    {!! HTML::script('libs/datatable/extensions/Select/js/dataTables.select.min.js') !!}
    {!! HTML::script('https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js') !!}

@endpush