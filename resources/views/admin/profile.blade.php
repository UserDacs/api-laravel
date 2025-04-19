@extends('layouts.app')
@section('content')
    <link href="/assets/plugins/photoswipe/dist/photoswipe.css" rel="stylesheet" />
    <link href="/assets/plugins/lity/dist/lity.min.css" rel="stylesheet" />



        {{-- <!-- BEGIN breadcrumb -->
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">Template</li>
    </ol>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">Template </h1>
    <!-- END page-header -->


    <!-- BEGIN row -->
    <div class="row">

    </div> --}}

    <div id="content" class="app-content p-0">
        <!-- BEGIN profile -->
        <div class="profile">
            <div class="profile-header">
                <!-- BEGIN profile-header-cover -->
                <div class="profile-header-cover"></div>
                <!-- END profile-header-cover -->
                <!-- BEGIN profile-header-content -->
                <div class="profile-header-content">
                    <!-- BEGIN profile-header-img -->
                    <div class="profile-header-img">
                        <img src="../assets/img/user/user-13.jpg" alt="" />
                    </div>
                    <!-- END profile-header-img -->
                    <!-- BEGIN profile-header-info -->
                    <div class="profile-header-info">
                        <h4 class="mt-0 mb-1">{{Auth::user()->firstname}} {{Auth::user()->lastname}}</h4>
                        <p class="mb-2">{{Auth::user()->role}}</p>
                        <a href="#" class="btn btn-xs btn-yellow">Edit Profile</a>
                    </div>
                    <!-- END profile-header-info -->
                </div>
                <!-- END profile-header-content -->

                <!-- END profile-header-tab -->
            </div>
        </div>
        <!-- END profile -->
        <!-- BEGIN profile-content -->
        <div class="profile-content">
            <!-- BEGIN tab-content -->
            <div class="tab-content p-0">

                <!-- END #profile-post tab -->
                <!-- BEGIN #profile-about tab -->
                <div class="tab-pane fade show active" id="profile-about">
                    <!-- BEGIN table -->
                    <div class="table-responsive form-inline">
                        <table class="table table-profile align-middle">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding-top:25px" class="field">First Name</td>
                                    <td style="padding-top:25px">
                                        <span class="firstname-display">
                                            <i class="fa fa-user me-2"></i> {{Auth::user()->firstname}}
                                            <a href="javascript:;" class="edit-btn text-decoration-none fw-bold ms-3" data-target="firstname">
                                                <i class="fa fa-plus fa-fw"></i> Edit
                                            </a>
                                        </span>
                                        <div class="firstname-form mt-2" style="display: none;">
                                            <input type="text" class="form-control form-control-sm d-inline w-25" placeholder="First Name" value="{{Auth::user()->firstname}}" />
                                            <button class="btn btn-success btn-sm ms-2 save-btn" data-target="firstname">Save</button>
                                            <button class="btn btn-secondary btn-sm ms-1 cancel-btn" data-target="firstname">Cancel</button>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding-top:25px" class="field">Last Name</td>
                                    <td style="padding-top:25px">
                                        <span class="lastname-display">
                                            <i class="fa fa-user me-2"></i> {{Auth::user()->lastname}}
                                            <a href="javascript:;" class="edit-btn text-decoration-none fw-bold ms-3" data-target="lastname">
                                                <i class="fa fa-plus fa-fw"></i> Edit
                                            </a>
                                        </span>
                                        <div class="lastname-form mt-2" style="display: none;">
                                            <input type="text" class="form-control form-control-sm d-inline w-25" placeholder="Last Name" value="{{Auth::user()->lastname}}" />
                                            <button class="btn btn-success btn-sm ms-2 save-btn" data-target="lastname">Save</button>
                                            <button class="btn btn-secondary btn-sm ms-1 cancel-btn" data-target="lastname">Cancel</button>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding-top:25px" class="field">Email</td>
                                    <td style="padding-top:25px">
                                        <span class="email-display">
                                            <i class="fa fa-envelope me-2"></i> {{Auth::user()->email}}
                                            <a href="javascript:;" class="edit-btn text-decoration-none fw-bold ms-3" data-target="email">
                                                <i class="fa fa-plus fa-fw"></i> Edit
                                            </a>
                                        </span>
                                        <div class="email-form mt-2" style="display: none;">
                                            <input type="email" class="form-control form-control-sm d-inline w-25" placeholder="Email" value="{{Auth::user()->email}}" />
                                            <button class="btn btn-success btn-sm ms-2 save-btn" data-target="email">Save</button>
                                            <button class="btn btn-secondary btn-sm ms-1 cancel-btn" data-target="email">Cancel</button>
                                        </div>
                                    </td>
                                </tr>



                                <tr>
                                    <td style="padding-top:25px" class="field">Phone</td>
                                    <td style="padding-top:25px">
                                        <span class="phone-display">
                                            <i class="fa fa-phone me-2"></i> {{Auth::user()->phone}}
                                            <a href="javascript:;" class="edit-btn text-decoration-none fw-bold ms-3" data-target="phone">
                                                <i class="fa fa-plus fa-fw"></i> Edit
                                            </a>
                                        </span>
                                        <div class="phone-form mt-2" style="display: none;">
                                            <input type="text" class="form-control form-control-sm d-inline w-25" placeholder="Phone" value="{{Auth::user()->phone}}" />
                                            <button class="btn btn-success btn-sm ms-2 save-btn" data-target="phone">Save</button>
                                            <button class="btn btn-secondary btn-sm ms-1 cancel-btn" data-target="phone">Cancel</button>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding-top:25px" class="field">Street</td>
                                    <td style="padding-top:25px">
                                        <span class="street-display">
                                            <i class="fa fa-road me-2"></i> {{Auth::user()->address_street}}
                                            <a href="javascript:;" class="edit-btn text-decoration-none fw-bold ms-3" data-target="street">
                                                <i class="fa fa-plus fa-fw"></i> Edit
                                            </a>
                                        </span>
                                        <div class="street-form mt-2" style="display: none;">
                                            <input type="text" class="form-control form-control-sm d-inline w-25" placeholder="Street" value="{{Auth::user()->address_street}}" />
                                            <button class="btn btn-success btn-sm ms-2 save-btn" data-target="street">Save</button>
                                            <button class="btn btn-secondary btn-sm ms-1 cancel-btn" data-target="street">Cancel</button>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding-top:25px" class="field">City</td>
                                    <td style="padding-top:25px">
                                        <span class="city-display">
                                            <i class="fa fa-building me-2"></i> {{Auth::user()->address_city}}
                                            <a href="javascript:;" class="edit-btn text-decoration-none fw-bold ms-3" data-target="city">
                                                <i class="fa fa-plus fa-fw"></i> Edit
                                            </a>
                                        </span>
                                        <div class="city-form mt-2" style="display: none;">
                                            <input type="text" class="form-control form-control-sm d-inline w-25" placeholder="City" value="{{Auth::user()->address_city}}" />
                                            <button class="btn btn-success btn-sm ms-2 save-btn" data-target="city">Save</button>
                                            <button class="btn btn-secondary btn-sm ms-1 cancel-btn" data-target="city">Cancel</button>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding-top:25px" class="field">State</td>
                                    <td style="padding-top:25px">
                                        <span class="state-display">
                                            <i class="fa fa-map me-2"></i> {{Auth::user()->address_state}}
                                            <a href="javascript:;" class="edit-btn text-decoration-none fw-bold ms-3" data-target="state">
                                                <i class="fa fa-plus fa-fw"></i> Edit
                                            </a>
                                        </span>
                                        <div class="state-form mt-2" style="display: none;">
                                            <input type="text" class="form-control form-control-sm d-inline w-25" placeholder="State" value="{{Auth::user()->address_state}}" />
                                            <button class="btn btn-success btn-sm ms-2 save-btn" data-target="state">Save</button>
                                            <button class="btn btn-secondary btn-sm ms-1 cancel-btn" data-target="state">Cancel</button>
                                        </div>
                                    </td>
                                </tr>

                                <tr >
                                    <td style="padding-top:25px" class="field">Zip Code</td>
                                    <td style="padding-top:25px">
                                        <span class="zipcode-display">
                                            <i class="fa fa-map-pin me-2"></i> {{Auth::user()->address_zip_code}}
                                            <a href="javascript:;" class="edit-btn text-decoration-none fw-bold ms-3" data-target="zipcode">
                                                <i class="fa fa-plus fa-fw"></i> Edit
                                            </a>
                                        </span>
                                        <div class="zipcode-form mt-2" style="display: none;">
                                            <input type="text" class="form-control form-control-sm d-inline w-25" placeholder="Zip Code" value="{{Auth::user()->address_zip_code}}" />
                                            <button class="btn btn-success btn-sm ms-2 save-btn" data-target="zipcode">Save</button>
                                            <button class="btn btn-secondary btn-sm ms-1 cancel-btn" data-target="zipcode">Cancel</button>
                                        </div>
                                    </td>
                                </tr>
                                {{-- <tr class="highlight">
                                    <td style="padding-top:25px" class="field">&nbsp;</td>
                                    <td style="padding-top:25px" class="">
                                        <button type="submit" class="btn btn-primary w-150px">Update</button>
                                        <button type="submit" class="btn border-0 w-150px ms-5px">Cancel</button>
                                    </td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                    <!-- END table -->
                </div>

                <!-- END #profile-friends tab -->
            </div>
            <!-- END tab-content -->
        </div>
        <!-- END profile-content -->
    </div>



        <!-- END row -->


    <script src="/assets/plugins/lity/dist/lity.min.js"></script>
    <script src="/assets/js/demo/profile.demo.js"></script>
    <!-- ================== END page-js ================== -->

    <!-- ================== BEGIN page-module-js ================== -->
    <script type="module" src="/assets/js/demo/gallery-v2.demo.js"></script>
    <!-- END #content -->
    <script>
        // $("#dashboard").addClass('active')
    </script>

<script>
    $(document).ready(function () {
        // Show form for editing
        $('.edit-btn').click(function () {
            const target = $(this).data('target');
            $(`.${target}-display`).hide();
            $(`.${target}-form`).slideDown();
        });

        // Cancel edit
        $('.cancel-btn').click(function () {
            const target = $(this).data('target');
            $(`.${target}-form`).slideUp(function () {
                $(`.${target}-display`).show();
            });
        });

        // Save button - AJAX request
        $('.save-btn').click(function () {
            const target = $(this).data('target');
            const input = $(`.${target}-form input`);
            const newValue = input.val();

            // Validate if value is not empty
            if (newValue.trim() === '') {
                alert('This field cannot be empty.');
                return;
            }

            // Send AJAX request to update value in the database
            $.ajax({
                url: '/update-field', // Route for updating field
                method: 'POST',
                data: {
                    field: target, // Field to be updated (first name, last name, etc.)
                    value: newValue, // New value
                    _token: '{{ csrf_token() }}' // CSRF Token
                },
                success: function (response) {
                    // Update display text after success
                    $(`.${target}-display`).html(`
                        <i class="fa fa-check-circle me-2 text-success"></i> ${newValue}
                        <a href="javascript:;" class="edit-btn text-decoration-none fw-bold ms-3" data-target="${target}">
                            <i class="fa fa-plus fa-fw"></i> Edit
                        </a>
                    `);

                    // Close the input form and show the updated text
                    $(`.${target}-form`).slideUp(function () {
                        $(`.${target}-display`).show();
                    });
                },
                error: function (xhr) {
                    alert('There was an error updating the field.');
                }
            });
        });
    });
</script>
@endsection
