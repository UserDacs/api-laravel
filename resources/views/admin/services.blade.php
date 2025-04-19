@extends('layouts.app')
@section('content')


<div id="content" class="app-content">
    <!-- BEGIN breadcrumb -->
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">Services</li>
    </ol>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">Services </h1>
    <!-- END page-header -->


    <div class="panel panel-inverse">
        <!-- BEGIN panel-heading -->
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-success" title="Add new shop"><i class="fa fa-plus"></i></a>
                {{-- <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i class="fa fa-times"></i></a> --}}
            </div>
        </div>
        <!-- END panel-heading -->
        <!-- BEGIN panel-body -->
        <div class="panel-body">
            <table id="data-table-default" width="100%" class="table table-striped table-bordered align-middle text-nowrap">
                <thead>
                    <tr>
                        <th width="1%"></th>
                        <th width="1%" data-orderable="false"></th>
                        <th class="text-nowrap">Shop name</th>
                        <th class="text-nowrap">Owner</th>
                        <th class="text-nowrap">Created Date</th>
                        <th class="text-nowrap" data-orderable="false" ></th>

                    </tr>
                </thead>
                <tbody>
                    <tr class="odd gradeX">
                        <td width="1%" class="fw-bold">1</td>
                        <td width="1%" class="with-img"><img src="../assets/img/user/user-1.jpg" class="rounded h-30px my-n1 mx-n1" /></td>
                        <td>Trident</td>
                        <td>Internet Explorer 4.0</td>
                        <td>Trident</td>
                        <td class="text-center">
                            <a href="javascript:;" class="btn btn-warning btn-icon btn-circle btn-sm">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="javascript:;" class="btn btn-danger btn-icon btn-circle btn-sm">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <!-- END panel-body -->

    </div>
</div>
<!-- END #content -->
<script>
    $("#services").addClass('active')
</script>
@endsection

