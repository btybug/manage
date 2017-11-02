@extends('btybug::layouts.admin')
@section('content')
    @php
        $a= \App\ExtraModules\ProValidator\Models\Validations::find(1);
    @endphp
    {!! BBRenderFormTest() !!}
@stop