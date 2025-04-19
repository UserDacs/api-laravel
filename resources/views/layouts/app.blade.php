
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>{{ config('app.name') }}</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />

	<!-- ================== BEGIN core-css ================== -->
	<link href="/assets/css/vendor.min.css" rel="stylesheet" />
	<link href="/assets/css/google/app.min.css" rel="stylesheet" />
	<!-- ================== END core-css ================== -->

	<!-- ================== BEGIN page-css ================== -->

	<link href="/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />
	<link href="/assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />

    <link href="/assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" />
	<link href="/assets/plugins/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />

	<!-- ================== END page-css ================== -->


    <!-- ================== BEGIN core-js ================== -->
	<script src="/assets/js/vendor.min.js"></script>
	<script src="/assets/js/app.min.js"></script>
	<!-- ================== END core-js ================== -->

	<!-- ================== BEGIN page-js ================== -->
	<script src="/assets/plugins/gritter/js/jquery.gritter.js"></script>
	<script src="/assets/plugins/flot/source/jquery.canvaswrapper.js"></script>
	<script src="/assets/plugins/flot/source/jquery.colorhelpers.js"></script>
	<script src="/assets/plugins/flot/source/jquery.flot.js"></script>
	<script src="/assets/plugins/flot/source/jquery.flot.saturated.js"></script>
	<script src="/assets/plugins/flot/source/jquery.flot.browser.js"></script>
	<script src="/assets/plugins/flot/source/jquery.flot.drawSeries.js"></script>
	<script src="/assets/plugins/flot/source/jquery.flot.uiConstants.js"></script>
	<script src="/assets/plugins/flot/source/jquery.flot.time.js"></script>
	<script src="/assets/plugins/flot/source/jquery.flot.resize.js"></script>
	<script src="/assets/plugins/flot/source/jquery.flot.pie.js"></script>
	<script src="/assets/plugins/flot/source/jquery.flot.crosshair.js"></script>
	<script src="/assets/plugins/flot/source/jquery.flot.categories.js"></script>
	<script src="/assets/plugins/flot/source/jquery.flot.navigate.js"></script>
	<script src="/assets/plugins/flot/source/jquery.flot.touchNavigate.js"></script>
	<script src="/assets/plugins/flot/source/jquery.flot.hover.js"></script>
	<script src="/assets/plugins/flot/source/jquery.flot.touch.js"></script>
	<script src="/assets/plugins/flot/source/jquery.flot.selection.js"></script>
	<script src="/assets/plugins/flot/source/jquery.flot.symbol.js"></script>
	<script src="/assets/plugins/flot/source/jquery.flot.legend.js"></script>
	<script src="/assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

	<script src="/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
	<script src="/assets/js/demo/dashboard.js"></script>


    <script src="/assets/plugins/datatables.net/js/dataTables.min.js"></script>
	<script src="/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
	<script src="/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
	<script src="/assets/js/demo/table-manage-default.demo.js"></script>
	<script src="/assets/plugins/@highlightjs/cdn-assets/highlight.min.js"></script>
	<script src="/assets/js/demo/render.highlight.js"></script>


    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
	<!-- ================== END page-js ================== -->


    <!-- Include Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


</head>
<body>
	<!-- BEGIN #loader -->
	<div id="loader" class="app-loader">
		<span class="spinner"></span>
	</div>
	<!-- END #loader -->
{{-- Add Class app-sidebar-minified app-content-full-height  --}}
	<!-- BEGIN #app -->
	<div id="app" class="app app-header-fixed app-sidebar-fixed  app-with-wide-sidebar">

        @include('layouts.topnav')


        @include('layouts.sidenav')


        @yield('content')


	</div>
    <div class="modal fade" id="modal-dialog">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Change Password</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>

                <div class="modal-body">
                    <form id="changePasswordForm">
                        <div class="mb-3">
                            <label for="oldPassword" class="form-label">Old Password</label>
                            <input type="password" class="form-control" id="oldPassword" placeholder="Enter old password">
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newPassword" placeholder="Enter new password">
                        </div>
                        <div class="mb-3">
                            <label for="confirmNewPassword" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirmNewPassword" placeholder="Confirm new password">
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" form="changePasswordForm">Update Password</button>
                </div>

            </div>
        </div>
    </div>
	<!-- END #app -->
    <script>
        $('#changePasswordForm').on('submit', function (e) {
            e.preventDefault();

            // Clear old validation
            $('#oldPassword, #newPassword, #confirmNewPassword').removeClass('is-invalid');

            $.ajax({
                url: '/change-password',
                method: 'POST',
                data: {
                    old_password: $('#oldPassword').val(),
                    new_password: $('#newPassword').val(),
                    confirm_new_password: $('#confirmNewPassword').val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    alert(response.message);
                    $('#modal-dialog').modal('hide');
                    $('#changePasswordForm')[0].reset();
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.old_password) {
                            $('#oldPassword').addClass('is-invalid')
                                .after(`<div class="invalid-feedback">${errors.old_password[0]}</div>`);
                        }
                        if (errors.new_password) {
                            $('#newPassword').addClass('is-invalid')
                                .after(`<div class="invalid-feedback">${errors.new_password[0]}</div>`);
                        }
                        if (errors.confirm_new_password) {
                            $('#confirmNewPassword').addClass('is-invalid')
                                .after(`<div class="invalid-feedback">${errors.confirm_new_password[0]}</div>`);
                        }
                    }
                }
            });
        });
    </script>

</body>
</html>
