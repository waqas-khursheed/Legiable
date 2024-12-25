@extends('layouts.master')
@section('title', 'Content')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi, welcome back!</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Content</a></li>
                    <li class="breadcrumb-item active">
                        <a href="javascript:void(0)">
                            {{ $content->type == "pp" ? "Privacy Policy" : "Terms & Conditions" }}
                        </a>
                    </li>
                </ol>
            </div>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Update {{ $content->type == "pp" ? "Privacy Policys" : "Term & Conditions" }}</h4>
                    </div>
                    <form class="" id="content-form">
                        <input type="hidden" name="id" value="{{ $content->id}}">

                        <div class="card-body">
                            <div name="content" id="summernote" class="summernote"> {!! $content->content !!}</div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-8 ml-auto">
                                <button type="button" class="btn btn-primary btn-content">Update</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@stop

@section('page-script')
<script>
    $(document).ready(function() {


        function showSuccessMessage() {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Content Updated Successfully',
                showConfirmButton: false,
                timer: 1000
            }).then(() => {
                setTimeout(function() {
                    window.location.reload();
                }, 500);
            });
        }

        // hide all error
        function hideAllErrors() {
            $('.error-message').hide();
        }
        $(document).on('click', '.btn-content', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Do you want to Update the changes?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Update',
                denyButtonText: `Don't Update`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    hideAllErrors();
                    var formData = new FormData($('#content-form')[0]);
                    formData.append("content", $("#summernote").summernote("code"))
                    formData.append('_token', '{{ csrf_token() }}');
                    $.ajax({
                        url: '{{ url("admin/content/update") }}',
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            console.log(response);
                            showSuccessMessage();
                        },
                        error: function(err) {
                            var errors = err.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $("[name='" + key + "'],[name='" + key + "[]']").after('<div class="error-message" style="color:red;font-weight: bold;">' + value + '</div>');
                                $("[name='" + key + "'],[name='" + key + "[]']").show();
                            });
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('Changes are not Updated', '', 'info')
                }
            })



        });
    });
</script>

@stop