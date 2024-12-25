<script>
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
</script>