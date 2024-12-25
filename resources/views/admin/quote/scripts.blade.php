<script>
    /*
|--------------------------------------------------------------------------
| Page Refresh
|--------------------------------------------------------------------------
*/
    function dataRefresh() {
        $.ajax({
            type: "get",
            url: "{{ url('admin/quote/read') }}",
            success: function(data) {
                $('#quote').html(data);
                // 
                var table = $('#example3, #example4, #example5').DataTable();
                $('#example tbody').on('click', 'tr', function() {
                    var data = table.row(this).data();
                });
            }
        });
    }
    $(document).on('click', '#quote-list', function(e) {
        e.preventDefault();
        dataRefresh();
    });
    dataRefresh();

    /*
    |--------------------------------------------------------------------------
    | Page Add
    |--------------------------------------------------------------------------
    */
    function dataAdd() {
        $.ajax({
            type: "get",
            url: "{{ url('/admin/quote/create') }}",
            success: function(data) {
                $('#quote').html(data);
            }
        });
    }
    $(document).on('click', '#add-quote', function(e) {
        e.preventDefault();
        dataAdd();
    });

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
    $(document).on("click", "#btn-add-quote", function(e) {
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

                var form = document.querySelector('#quote-form');
                var data = new FormData(form);

                $.ajax({
                    url: "{{ url('admin/quote/save')}}",
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
                        dataRefresh();
                        showSuccessMessage(response.success);
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
    /*
|--------------------------------------------------------------------------
|  Edit
|--------------------------------------------------------------------------
*/
    $(document).on('click', '#quote-edit', function(e) {
        e.preventDefault();

        var id = $(this).data('id');
        $.ajax({
            url: "{{ url('/admin/quote/edit') }}",
            type: "GET",
            data: {
                id: id,
            },
            success: function(response) {
                $('#quote').html(response);
            },
            error: function(err) {

            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    |  Update
    |--------------------------------------------------------------------------
    */

    $(document).on("click", "#btn-update-quote", function(e) {
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

                var form = document.querySelector('#quote-update-form');
                var data = new FormData(form);

                $.ajax({
                    url: "{{ url('/admin/quote/update') }}",
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
                        dataRefresh();
                        showSuccessMessage(response.success);
                    },
                    error: function(err) {
                        Swal.close();
                        showErrorMessage();
                        var errors = err.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $("[name='" + key + "'],[name='" + key + "[]']").after(' <span class="error-message" style="color:red; font-weight: bold; font-size:12px;">' + value + '</span>');
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
    /*
|--------------------------------------------------------------------------
|  Delete single Row
|--------------------------------------------------------------------------
*/
    function deleteData(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('/admin/quote/delete') }}" + '/' + id,
                    type: "get",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Quote Deleted Successfully',
                            showConfirmButton: false,
                            timer: 1000
                        });
                        dataRefresh();
                    },
                    error: function() {

                    }
                })
            }
        })
    }


    /*
    |--------------------------------------------------------------------------
    |  Default single Row
    |--------------------------------------------------------------------------
    */
    function defaultData(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, default it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('/admin/quote/default') }}" + '/' + id,
                    type: "get",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Quote Default Successfully',
                            showConfirmButton: false,
                            timer: 1000
                        });
                        dataRefresh();
                    },
                    error: function() {

                    }
                })
            }
        })
    }
</script>