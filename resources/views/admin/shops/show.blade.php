@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ $shop->shop_name }}</h4>
            <span class="badge bg-{{ $shop->shop_status === 'active' ? 'success' : ($shop->shop_status === 'pending' ? 'warning' : 'secondary') }}">
                {{ ucfirst($shop->shop_status) }}
            </span>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    @if ($shop->shop_image)
                        <img src="{{ $shop->shop_image }}" alt="Shop Image" class="img-fluid rounded">
                    @else
                        <img src="https://via.placeholder.com/300x200?text=No+Image" class="img-fluid rounded" alt="No Image">
                    @endif
                </div>
                <div class="col-md-8">
                    <h5>Shop Information</h5>
                    <p><strong>Address:</strong> {{ $shop->shop_address }}</p>
                    <p><strong>Details:</strong> {{ $shop->shop_details ?? 'N/A' }}</p>
                    <p><strong>Location:</strong> {{ $shop->shop_lat ?? '-' }}, {{ $shop->shop_long ?? '-' }}</p>
                </div>
            </div>

            <hr>

            <h5>Owner Information</h5>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Name:</strong> {{ $shop->firstname }} {{ $shop->lastname }}</p>
                    <p><strong>Email:</strong> {{ $shop->email }}</p>
                    <p><strong>Phone:</strong> {{ $shop->phone ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Address:</strong></p>
                    <p>{{ $shop->address_street }}, {{ $shop->address_city }}, {{ $shop->address_state }} {{ $shop->address_zip_code }}</p>
                </div>
            </div>

            @if ($shop->shop_national_id || $shop->cor)
                <hr>
                <h5>Documents</h5>
                <div class="row">
                    @if ($shop->shop_national_id)
                        <div class="col-md-6 mb-3">
                            <p><strong>National ID:</strong></p>
                            <img src="{{ $shop->shop_national_id }}" alt="National ID" class="img-fluid rounded border">
                        </div>
                    @endif

                    @if ($shop->cor)
                        <div class="col-md-6 mb-3">
                            <p><strong>Certificate of Registration:</strong></p>
                            <img src="{{ $shop->cor }}" alt="Certificate of Registration" class="img-fluid rounded border">
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Status Toggle Button -->
        <div class="card-footer text-muted d-flex justify-content-between align-items-center">
            <div>
                Created: {{ $shop->shop_created_at }} |
                Updated: {{ $shop->shop_updated_at }}
            </div>

            <form action="{{ route('shops.toggleStatus', $shop->shop_id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm 
                    {{ $shop->shop_status === 'pending' ? 'btn-success' : ($shop->shop_status === 'active' ? 'btn-danger' : 'btn-primary') }}">
                    {{
                        $shop->shop_status === 'pending' ? 'Approve' :
                        ($shop->shop_status === 'active' ? 'Inactivate' : 'Activate')
                    }}
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
