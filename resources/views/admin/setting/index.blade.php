@extends('layouts.master')
@section('title', 'Settings')

@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Setting</h4>
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
                        <h4 class="card-title">Update Setting</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-validation">
                            <form class="" id="setting-form">
                                <div class="row">
                                    <input type="hidden" name="id" value="{{ $setting->id}}">
                                    <div class="col-xl-12">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Company Name :
                                            </label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" id="val-username" value="{{ $setting->company_name}}" name="company_name" placeholder="Enter a Company Name..">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Election Date :
                                            </label>
                                            <div class="col-lg-8">
                                                <input type="date" class="form-control" id="val-username" value="{{ $setting->election_date}}" name="election_date" min="<?= date('Y-m-d') ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">About App :
                                            </label>
                                            <div class="col-lg-8">
                                                <textarea class="form-control" name="about_app" rows="5">{{$setting->about_app}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="button" class="btn btn-primary btn-setting">Update</button>
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
<script>
    $(document).ready(function() {


        function showSuccessMessage() {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Setting Updated Successfully',
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
        $(document).on('click', '.btn-setting', function(e) {
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
                    var formData = new FormData($('#setting-form')[0]);
                    formData.append('_token', '{{ csrf_token() }}');
                    $.ajax({
                        url: '{{ url("admin/update-setting") }}',
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
                                $("[name='" + key + "'],[name='" + key + "[]']").after('<div class="error-message" style="color:red;">' + value + '</div>');
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