@extends('layouts.app')
@section('content')


<div id="content" class="app-content">
    <!-- BEGIN breadcrumb -->
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">Dashboard</h1>
    <!-- END page-header -->

    <!-- BEGIN row -->
    <div class="row">
        <!-- BEGIN col-3 -->
        <div class="col-xl-3 col-md-6">
            <div class="widget widget-stats bg-blue">
                <div class="stats-icon"><i class="fa fa-desktop"></i></div>
                <div class="stats-info">
                    <h4>TOTAL TECHNICIANS</h4>
                    <p>{{total_technician()}}</p>
                </div>
                <div class="stats-link">
                    <a href="javascript:;">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- END col-3 -->
        <!-- BEGIN col-3 -->
        <div class="col-xl-3 col-md-6">
            <div class="widget widget-stats bg-info">
                <div class="stats-icon"><i class="fa fa-link"></i></div>
                <div class="stats-info">
                    <h4>TOTAL SERVICES</h4>
                    <p>{{total_services()}}</p>
                </div>
                <div class="stats-link">
                    <a href="javascript:;">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- END col-3 -->
        <!-- BEGIN col-3 -->
        <div class="col-xl-3 col-md-6">
            <div class="widget widget-stats bg-orange">
                <div class="stats-icon"><i class="fa fa-users"></i></div>
                <div class="stats-info">
                    <h4>TOTAL CATEGORY</h4>
                    <p>{{total_category()}}</p>
                </div>
                <div class="stats-link">
                    <a href="javascript:;">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- END col-3 -->
        <!-- BEGIN col-3 -->
        <div class="col-xl-3 col-md-6">
            <div class="widget widget-stats bg-red">
                <div class="stats-icon"><i class="fa fa-clock"></i></div>
                <div class="stats-info">
                    <h4>TOTAL USERS</h4>
                    <p>{{total_users()}}</p>
                </div>
                <div class="stats-link">
                    <a href="javascript:;">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- END col-3 -->
    </div>
    <!-- END row -->

    <!-- BEGIN row -->
    <div class="row">

        <div class="col-lg-9">
            <div class="panel panel-inverse" data-sortable-id="index-1">
                <div class="panel-heading">
                    <h4 class="panel-title">Website Analytics (Last 7 Days)</h4>

                </div>
                <div class="panel-body pe-1">
                    <div id="interactive-chart" class="h-300px"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <!-- BEGIN card -->
            <div class="card border-0 mb-3 ">
                <!-- BEGIN card-body -->
                <div class="card-body">
                    <!-- BEGIN title -->
                    <div class="mb-3 fs-13px">
                        <b>TOP PRODUCTS BY UNITS SOLD</b>
                        <span class="ms-2  text-muted"><i class="fa fa-info-circle" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-title="Top products with units sold" data-bs-placement="top" data-bs-content="Products with the most individual units sold. Includes orders from all sales channels."></i></span>
                    </div>
                    <!-- END title -->
                    <!-- BEGIN product -->
                    <div class="d-flex align-items-center mb-10px pb-2px">
                        <div class="widget-img rounded-3 me-10px bg-white p-3px w-40px h-50px">
                            <div class="h-100 w-100" style="background: url(/assets/img/product/product-8.jpg) center no-repeat; background-size: auto 100%;"></div>
                        </div>
                        <div class="text-truncate">
                            <div  class="fw-bold">Apple iPhone XR (2024)</div>
                            <div class="text-dark-lighter fs-13px">$799.00</div>
                        </div>
                        <div class="ms-auto text-center">
                            <div class="fw-500"><span data-animation="number" data-value="195">0</span></div>
                            <div class="text-dark-lighter fs-13px">sold</div>
                        </div>
                    </div>
                    <!-- END product -->
                    <!-- BEGIN product -->
                    <div class="d-flex align-items-center mb-10px pb-2px">
                        <div class="widget-img rounded-3 me-10px bg-white p-3px w-40px h-50px">
                            <div class="h-100 w-100" style="background: url(/assets/img/product/product-9.jpg) center no-repeat; background-size: auto 100%;"></div>
                        </div>
                        <div class="text-truncate">
                            <div  class="fw-bold">Apple iPhone XS (2024)</div>
                            <div class="text-dark-lighter fs-13px">$1,199.00</div>
                        </div>
                        <div class="ms-auto text-center">
                            <div class="fw-500"><span data-animation="number" data-value="185">0</span></div>
                            <div class="text-dark-lighter fs-13px">sold</div>
                        </div>
                    </div>
                    <!-- END product -->
                    <!-- BEGIN product -->
                    <div class="d-flex align-items-center mb-10px pb-2px">
                        <div class="widget-img rounded-3 me-10px bg-white p-3px w-40px h-50px">
                            <div class="h-100 w-100" style="background: url(/assets/img/product/product-10.jpg) center no-repeat; background-size: auto 100%;"></div>
                        </div>
                        <div class="text-truncate">
                            <div  class="fw-bold">Apple iPhone XS Max (2024)</div>
                            <div class="text-dark-lighter fs-13px">$3,399</div>
                        </div>
                        <div class="ms-auto text-center">
                            <div class="fw-500"><span data-animation="number" data-value="129">0</span></div>
                            <div class="text-dark-lighter fs-13px">sold</div>
                        </div>
                    </div>
                    <!-- END product -->
                    <!-- BEGIN product -->
                    <div class="d-flex align-items-center mb-10px pb-2px">
                        <div class="widget-img rounded-3 me-10px bg-white p-3px w-40px h-50px">
                            <div class="h-100 w-100" style="background: url(/assets/img/product/product-11.jpg) center no-repeat; background-size: auto 100%;"></div>
                        </div>
                        <div class="text-truncate">
                            <div  class="fw-bold">Huawei Y5 (2024)</div>
                            <div class="text-dark-lighter fs-13px">$99.00</div>
                        </div>
                        <div class="ms-auto text-center">
                            <div class="fw-500"><span data-animation="number" data-value="96">0</span></div>
                            <div class="text-dark-lighter fs-13px">sold</div>
                        </div>
                    </div>
                    <!-- END product -->
                    <!-- BEGIN product -->
                    <div class="d-flex align-items-center">
                        <div class="widget-img rounded-3 me-10px bg-white p-3px w-40px h-50px">
                            <div class="h-100 w-100" style="background: url(/assets/img/product/product-12.jpg) center no-repeat; background-size: auto 100%;"></div>
                        </div>
                        <div class="text-truncate">
                            <div  class="fw-bold">Huawei Nova 4 (2024)</div>
                            <div class="text-dark-lighter fs-13px">$499.00</div>
                        </div>
                        <div class="ms-auto text-center">
                            <div class="fw-500"><span data-animation="number" data-value="55">0</span></div>
                            <div class="text-dark-lighter fs-13px">sold</div>
                        </div>
                    </div>
                    <!-- END product -->
                </div>
                <!-- END card-body -->
            </div>
            <!-- END card -->
        </div>
    </div>
    <!-- END row -->
</div>
<!-- END #content -->
<script>
    $("#dashboard").addClass('active')
</script>
@endsection

