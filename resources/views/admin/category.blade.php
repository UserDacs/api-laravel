@extends('layouts.app')
@section('content')


<div id="content" class="app-content">
    <!-- BEGIN breadcrumb -->
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">Category</li>
    </ol>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">Category </h1>
    <!-- END page-header -->


    <div class="panel panel-inverse">
        <!-- BEGIN panel-heading -->
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="{{ route('admin-category-create') }}" class="btn btn-xs btn-icon btn-success" title="Add new category"><i class="fa fa-plus"></i></a>
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

                        <th class="text-nowrap">Category name</th>
                        <th class="text-nowrap">Description</th>
                        <th class="text-nowrap">Status</th>
                        <th class="text-nowrap" data-orderable="false" ></th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr class="odd gradeX">

                        <td>{{$category->category_name}}</td>
                        <td>{{$category->description}}</td>
                        <td>{{$category->status}}</td>
                        <td class="text-center">
                            <a href="{{ route('admin-category-edit', $category->id) }}" class="btn btn-warning btn-icon btn-circle btn-sm">
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
</div>
<!-- END #content -->
<script>
    $("#category").addClass('active')
</script>
@endsection

