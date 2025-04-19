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
</head>
<body class='pace-top'>
	<!-- BEGIN #loader -->
	<div id="loader" class="app-loader">
		<span class="spinner"></span>
	</div>
	<!-- END #loader -->


	<!-- BEGIN #app -->
	<div id="app" class="app">
		<!-- BEGIN login -->
		<div class="login login-v1">
			<!-- BEGIN login-container -->
			<div class="login-container">
				<!-- BEGIN login-header -->
				<div class="login-header">
					<div class="brand">
						<div >
							<span class="logo" style="font-size: 25px !important;">
								<span class="text-blue">{{ config('app.name') }} </span>
                                &nbsp;&nbsp;Admin
							</span>

						</div>

					</div>
					<div class="icon">
						<i class="fa fa-lock"></i>
					</div>
				</div>
				<!-- END login-header -->

				<!-- BEGIN login-body -->
				<div class="login-body">
					<!-- BEGIN login-content -->
					<div class="login-content fs-13px">
						<form id="loginForm">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-floating mb-20px">
                                        <input type="email" name="email" class="form-control fs-13px h-45px" id="emailAddress" placeholder="Email Address" />
                                        <label for="emailAddress" class="d-flex align-items-center">Email Address</label>
                                    </div>

                                    <div class="form-floating mb-20px">
                                        <input type="password" name="password" class="form-control fs-13px h-45px" id="password" placeholder="Password" />
                                        <label for="password" class="d-flex align-items-center">Password</label>
                                    </div>

                                    <div class="login-buttons">
                                        <button type="submit" class="btn btn-theme h-45px d-block w-100 btn-lg">Sign me in</button>
                                    </div>
                                </div>

                                <div class="col-12 pt-2">
                                    <div id="alertBox" class="alert alert-danger fade d-none mb-3" role="alert"></div>
                                </div>
                            </div>



						</form>

					</div>

					<!-- END login-content -->
				</div>
				<!-- END login-body -->
			</div>

			<!-- END login-container -->
		</div>

		<!-- END login -->


		<!-- END scroll-top-btn -->
	</div>
	<!-- END #app -->

	<!-- ================== BEGIN core-js ================== -->
	<script src="/assets/js/vendor.min.js"></script>
	<script src="/assets/js/app.min.js"></script>
	<!-- ================== END core-js ================== -->

    <script>
        $('#loginForm').on('submit', function (e) {
            e.preventDefault();

            const alertBox = $('#alertBox');
            const emailInput = $('#emailAddress');
            const passwordInput = $('#password');

            // Reset error state
            alertBox.addClass('d-none').removeClass('alert-danger alert-success show').text('');
            emailInput.removeClass('is-invalid');
            passwordInput.removeClass('is-invalid');

            $.ajax({
                url: "{{ route('admin.login') }}",
                type: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status === 'success') {
                        alertBox
                            .removeClass('d-none alert-danger')
                            .addClass('alert-success show')
                            .hide()
                            .text(response.message)
                            .fadeIn();

                        setTimeout(() => {
                            window.location.href = response.redirect;
                        }, 1000);
                    }
                },
                error: function (xhr) {
                    let res = xhr.responseJSON;
                    let errorMsg = 'Something went wrong. Please try again.';

                    if (res?.errors) {
                        if (res.errors.email) {
                            emailInput.addClass('is-invalid');
                            errorMsg = res.errors.email[0];
                        }
                        if (res.errors.password) {
                            passwordInput.addClass('is-invalid');
                            errorMsg = res.errors.password[0];
                        }
                    } else if (res?.message) {
                        errorMsg = res.message;
                    }

                    alertBox
                        .removeClass('d-none alert-success')
                        .addClass('alert-danger show')
                        .hide()
                        .text(errorMsg)
                        .fadeIn();
                }
            });
        });
    </script>
</body>
</html>
