@extends('layouts.master')
@section('title', 'Help And Feedbacks')

@section('content')

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>All Help And Feedbacks</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">All Help And Feedbacks</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row tab-content">
                    <div id="list-view" class="tab-pane fade active show col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">All Help And Feedbacks</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Full Name</th>
                                                <th>Profile Image</th>
                                                <th>Subject</th>
                                                <th>description</th>
                                                <th>Images</th>
                                                <th>Created At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($helpAndFeedbacks) > 0)
                                            @foreach($helpAndFeedbacks as $key=>$helpAndFeedback)
                                            <tr>
                                                <td>{{ ++$key }}</td>

                                                <td>{{ $helpAndFeedback->user->full_name }}</td>
                                                <td>
                                                    @if(!empty($helpAndFeedback->user->profile_image))
                                                    <a href="{{ asset($helpAndFeedback->user->profile_image) }}" target="_blank">
                                                        <img src="{{ asset($helpAndFeedback->user->profile_image) }}" with="50" height="60">
                                                    </a>
                                                    @endif
                                                </td>
                                                <td>{{ $helpAndFeedback->subject }}</td>
                                                <td>{{ $helpAndFeedback->description }}</td>
                                                <td>
                                                    @if(!empty($helpAndFeedback->images))
                                                    @php $images = json_decode($helpAndFeedback->images); @endphp
                                                    @foreach($images as $image)
                                                    <a href="{{ asset($image) }}" target="_blank">
                                                        <img src="{{ asset($image) }}" with="40" height="40">
                                                    </a>
                                                    @endforeach
                                                    @endif
                                                </td>
                                                <td>{{ $helpAndFeedback->created_at }}</td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->
@stop

@section('page-script')
@include('admin.quote.scripts')
@stop