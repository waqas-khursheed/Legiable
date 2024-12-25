@extends('layouts.master')
@section('title', 'My Right')

@section('content')

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <span id="my_right">
    </span>
</div>
<!--**********************************
    Content body end
***********************************-->
@stop

@section('page-script')
@include('admin.my-right.scripts')
@stop