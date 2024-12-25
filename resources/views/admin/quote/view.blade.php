@extends('layouts.master')
@section('title', 'Quote')

@section('content')

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <span id="quote">
    </span>
</div>
<!--**********************************
    Content body end
***********************************-->
@stop

@section('page-script')
@include('admin.quote.scripts')
@stop