@extends('layouts.master')
@section('title', 'White House Detail')

@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>White House Detail</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">

            </div>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Update White House Detail</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-validation">
                            <form class="" id="white-house-form">
                                <div class="row">
                                    <input type="hidden" name="id" value="{{ $white_house->id}}">
                                    <div class="col-xl-12">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Title :
                                            </label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" id="val-username" value="{{ $white_house->title}}" name="title" placeholder="Enter a Title..">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Personal Detail :
                                            </label>
                                            <div class="col-lg-8">
                                                <textarea class="form-control" name="personal_detail" rows="5">{{$white_house->personal_detail}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Additional Information :
                                            </label>
                                            <div class="col-lg-8">
                                                <textarea class="form-control" name="additional_information" rows="5">{{$white_house->additional_information}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="button" class="btn btn-primary btn-submit">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('page-script')
@include('include.page-script')
<script>
    $(document).on("click", ".btn-submit", function(e) {
        e.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger',
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: 'Are you sure to submit this form?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Submit Form!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {

                var form = document.querySelector('#white-house-form');
                var data = new FormData(form);

                $.ajax({
                    url: "{{ url('admin/update-white-house-detail')}}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    async: true,
                    beforeSend: function() {
                        loaderMessage();
                    },
                    success: function(response) {
                        showSuccessMessage(response.success);
                        setTimeout(function() {
                            window.location.reload();
                        }, 500);
                    },
                    error: function(err) {
                        Swal.close();
                        showErrorMessage();
                        var errors = err.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            let elem;
                            if (key.includes(".")) {
                                let err_elems = key.split(".");
                                $("[name='" + err_elems[0] + "[]']").eq(err_elems[1]).after('<div class="error-message" style="color:red;">' + value + '</div>');
                            } else {
                                $("[name='" + key + "'],[name='" + key + "[]']").after('<div class="error-message" style="color:red;">' + value + '</div>');
                            }
                        });
                    },
                });

            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your From Request Process Has Cancelled!',
                    'error'
                )
            }
        });
    });
</script>

@stop