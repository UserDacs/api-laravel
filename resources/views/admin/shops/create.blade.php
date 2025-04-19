@extends('layouts.app')
@section('content')

<div id="content" class="app-content">
    <!-- BEGIN breadcrumb -->
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">Create Shop</li>
    </ol>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">Create Shop </h1>
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
            <form action="{{ route('admin-shop-store') }}" method="POST">
                @csrf
                <fieldset>
                    @include('admin.shops.form', ['shop' => null])

                </fieldset>
            </form>
        </div>
        <!-- END panel-body -->

    </div>
    <!-- END row -->
</div>

@endsection
