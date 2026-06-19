<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="{{asset('/assets/favicon.png')}}">
    <title>
        {{ $title ?? '' }}
        -
        Dashboard
    </title>
    <link rel="stylesheet" href="{{ asset('/assets/plugins/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet"
          href="{{ asset('/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/dist/css/adminlte.min_en.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/admin_styles.css') }}?v=1">
    <style>
        /*media print*/
        @media print {
            .remove_print {
                display: none;
            }

            /* reset table styles  */
            .table {
                width: 95%;
                margin: auto;
            }

            .table-responsive {
                overflow-x: unset !important;
                overflow: unset !important;
            }

        }

        [class*=sidebar-dark-] {
            background-color: #002f5e;
        }

        input[type=checkbox] {
            width: 20px;
            height: 20px;
        }

        [data-tiny-editor] {
            height: 400px;
            border: 1px solid #ccc;
            padding: 1rem;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/4.1.5/css/flag-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fonts.css') }}">

    @yield('styles')
    @stack('push_styles')

</head>

<body class="hold-transition sidebar-mini layout-fixed text-sm">
<div class="wrapper">

    <!-- append ajax modal -->
    <div class="modal_backend"></div>

    @if (isset($enableLoader) && $enableLoader)
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('/site/logo.png') }}" alt="logo" height="80"
                 width="80">
        </div>
    @endif

    @include('admin.layouts.nav')
    @include('admin.layouts.side')

    @yield('content')

    <footer class="main-footer">
        <strong>All rights Reserved &copy; {{ date('Y') }} </strong>
        <div class="float-right d-none d-sm-inline-block">
            <b>NEN</b>
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>

</div>
<!-- ./wrapper -->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Remove all input elements with the name "__ncforminfo"
        var inputs = document.querySelectorAll('input[name="__ncforminfo"]');
        inputs.forEach(function (input) {
            input.parentNode.removeChild(input);
        });
    });
</script>

<script src="{{ asset('/assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/sparklines/sparkline.js') }}"></script>
<script src="{{ asset('/assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('/assets/dist/js/adminlte.js') }}"></script>
{{-- <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script> --}}
<script src="{{ asset('assets/admin/sweetalert/sweetalert2@10.js') }}"></script>
<script src="{{ asset('/assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>

@include('components.file-upload-script')
@include('includes.toastr')
@yield('scripts')
@stack('scripts')
@if(isset($hasEditor))
    <script src="https://unpkg.com/tiny-editor/dist/bundle.js"></script>
@endif
<script>
    $("[rel='tooltip']").tooltip();

    function destroy(link, text) {
        Swal.fire({
            title: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = link;
                Swal.fire(
                    'Done!',
                    'Processing',
                    'success'
                )
            }
        })
    }

    $(function () {
        return $(".modal").on("show.bs.modal", function () {
            var curModal;
            curModal = this;
            $(".modal").each(function () {
                if (this !== curModal) {
                    $(this).modal("hide");
                    $('.modal-backdrop').remove();
                }
            });
        });
    });

    $('.dataTableRows').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": true,
        "language": {
            "lengthMenu": "Show _MENU_ per page",
            "zeroRecords": "There is no data",
            "info": "عرض صفحة _PAGE_ من _PAGES_",
            "infoEmpty": "There is no data",
            "infoFiltered": "(تم البحث من _MAX_ مجموع البيانات)",
            "paginate": {
                "previous": "Previous",
                "next": "Next"
            }
        }
    });

    function smoothLoader(ele) {
        $(ele).html('<i class="fa fa-spinner fa-spin"></i>');
    }

    function printPage() {
        window.print();
    }

    function downloadCanvas(eleId) {
        let link = document.createElement("a");
        link.download = eleId + ".png";
        link.href = document.getElementById(eleId).toDataURL();
        link.click();
    }

    $('.with_loader').on('submit', function () {
        const submitButton = $(this).find('button[type="submit"]');
        submitButton.prop('disabled', true);
        submitButton.html('<i class="fa fa-spinner fa-spin"></i> Loading ...');
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    @if(isset($hasEditor))

        const editorElement = document.querySelector('[data-tiny-editor]');
        const form = editorElement.closest('form');

        const inputName = editorElement.getAttribute('data-input');

        form.addEventListener('submit', function (e) {
            const input = form.querySelector(`[name="${inputName}"]`);
            if (input) {
                input.value = editorElement.innerHTML;
            }
        });

    @endif

</script>

</body>

</html>
