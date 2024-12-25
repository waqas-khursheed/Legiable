@extends('layouts.master')
@section('title', 'Spending')

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
                    <h4>Fetch Spending</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Fetch Spending</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-xxl-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Fetch Spending Info</h5>
                    </div>
                    <div class="card-body">
                        <form id="spending-form">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Fiscal Year</label>
                                        <div class="dropdown bootstrap-select form-control">
                                            <select class="form-control" name="fiscal_year" tabindex="-98">
                                                <option value="">Select Fiscal Year</option>
                                                @for ($year = 2017; $year <= date('Y'); $year++)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                    @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <button type="button" id="btn-add-spending" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
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
<script>
    /*
    |--------------------------------------------------------------------------
    | Page Add
    |--------------------------------------------------------------------------
    */
    function hideAllErrors() {
        $('.error-message').hide();
    }

    function showSuccessMessage(success) {
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: success,
            showConfirmButton: false,
            timer: 1000
        });
    }

    function loaderMessage() {
        // loader start
        let timerInterval;
        Swal.fire({
            title: 'Auto close alert!',
            html: 'Loading... Please wait.',
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
                const b = Swal.getHtmlContainer().querySelector('b');
                timerInterval = setInterval(() => {
                    b.textContent = Swal.getTimerLeft();
                }, 1000);
            },
            willClose: () => {
                clearInterval(timerInterval);
            },
        }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log('I was closed by the timer');
            }
        });
    }

    // Function to display SweetAlert error message
    function showErrorMessage() {
        toastr.error("This Is error Message", {
            positionClass: "toast-top-right",
            timeOut: 5e3,
            closeButton: !0,
            debug: !1,
            newestOnTop: !0,
            progressBar: !0,
            preventDuplicates: !0,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
            tapToDismiss: !1
        });
    }
    // Add Quote 
    $(document).on("click", "#btn-add-spending", function(e) {
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
                hideAllErrors();

                var form = document.querySelector('#spending-form');
                var data = new FormData(form);

                $.ajax({
                    url: "{{ url('admin/fetch/spending-data')}}",
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