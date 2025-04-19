@extends('layouts.app')
@section('content')


<div id="content" class="app-content">
    <!-- BEGIN breadcrumb -->
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">Customers </li>
    </ol>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">Customers </h1>
    <!-- END page-header -->


    <div class="panel panel-inverse">
        <!-- BEGIN panel-heading -->

        <!-- END panel-heading -->
        <!-- BEGIN panel-body -->
        <div class="panel-body">
            <table id="data-table-default" width="100%" class="table table-striped table-bordered align-middle text-nowrap">
                <thead>
                    <tr>
                        <th width="1%" data-orderable="false"></th>
                        <th class="text-nowrap">Fullname</th>
                        <th class="text-nowrap">Email</th>
                        <th class="text-nowrap">Created Date</th>
                        <th class="text-nowrap">Status</th>
                        <th class="text-nowrap" data-orderable="false" ></th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr class="odd gradeX">
                        <td width="1%" class="with-img"><img src="{{ $user->image_path }}" class="rounded h-30px my-n1 mx-n1" /></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('F j, Y g:i A') }}</td>
                        <td>{{ $user->status }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin-edit', $user->id) }}" class="btn btn-warning btn-icon btn-circle btn-sm">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="javascript:;" class="btn btn-danger btn-icon btn-circle btn-sm">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
        <!-- END panel-body -->

    </div>
    <!-- END row -->
</div>
<!-- END #content -->
<script>
    $("#users").addClass('active')
    $("#users-customer").addClass('active')
</script>
@endsection

