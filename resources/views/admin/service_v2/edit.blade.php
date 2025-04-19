
@extends('layouts.app')
@section('content')
<div id="content" class="app-content">
    <!-- BEGIN breadcrumb -->
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">Edit service</li>
    </ol>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">Edit service </h1>
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
            <form action="{{ route('admin-service-update', $service->id) }}" method="POST"  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <fieldset>
                    @include('admin.service_v2.form', ['service' => $service])

                </fieldset>
            </form>
        </div>
        <!-- END panel-body -->

    </div>
    <!-- END row -->
</div>

@endsection
