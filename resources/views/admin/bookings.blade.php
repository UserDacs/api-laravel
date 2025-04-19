@extends('layouts.app')
@section('content')


<div id="content" class="app-content">
    <!-- BEGIN breadcrumb -->
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">Bookings</li>
    </ol>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">Bookings </h1>
    <!-- END page-header -->

    <div class="panel panel-inverse">
        <!-- BEGIN panel-heading -->

        <!-- END panel-heading -->
        <!-- BEGIN panel-body -->
        <div class="panel-body">
            <table id="data-table-default" width="100%" class="table table-striped table-bordered align-middle text-nowrap">
                <thead>
                    <tr>
                        <th width="1%"></th>
                        {{-- <th width="1%" data-orderable="false"></th> --}}
                        <th class="text-nowrap">Service name</th>
                        <th class="text-nowrap">Technician</th>
                        <th class="text-nowrap">Price</th>
                        <th class="text-nowrap">Location</th>
                        <th class="text-nowrap">Customer</th>
                        <th class="text-nowrap">Status</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)

                    <tr class="odd gradeX">
                        <td width="1%" class="fw-bold">{{$booking->booking_id}}</td>
                        {{-- <td width="1%" class="with-img"><img src="../assets/img/user/user-1.jpg" class="rounded h-30px my-n1 mx-n1" /></td> --}}
                        <td>{{$booking->service_name}}</td>
                        <td>{{$booking->technician_firstname}} {{$booking->technician_lastname}}</td>
                        <td>{{$booking->service_price}}</td>
                        <td>{{$booking->booking_address}}</td>
                        <td>{{$booking->fullname}}</td>
                        <td>{{$booking->booking_status}}</td>
                        {{-- <td class="text-center">
                            <a href="javascript:;" class="btn btn-warning btn-icon btn-circle btn-sm">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="javascript:;" class="btn btn-danger btn-icon btn-circle btn-sm">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td> --}}
                    </tr>


                    @endforeach

                </tbody>
            </table>
        </div>
        <!-- END panel-body -->

    </div>
    <!-- END row -->
    <!-- END row -->
</div>
<!-- END #content -->
<script>
    $("#bookings").addClass('active')
</script>
@endsection

