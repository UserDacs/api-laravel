
@extends('layouts.app')
@section('content')
<div id="content" class="app-content">
    <!-- BEGIN breadcrumb -->
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">Edit User</li>
    </ol>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">Edit User </h1>
    <!-- END page-header -->


    <!-- BEGIN row -->
    <div class="panel panel-inverse" data-sortable-id="form-stuff-11">
        <!-- BEGIN panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">Form</h4>

        </div>
        <!-- END panel-heading -->
        <!-- BEGIN panel-body -->
        <div class="panel-body">
            <form action="{{ route('admin-update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <fieldset>
                    @include('admin.users.form', ['user' => $user])
                    <button type="submit" class="btn btn-primary w-100px me-5px">Save</button>
                    <a href="javascript:;" class="btn btn-default w-100px">Cancel</a>
                </fieldset>
            </form>
        </div>
        <!-- END panel-body -->

    </div>
    <!-- END row -->
</div>

@endsection
