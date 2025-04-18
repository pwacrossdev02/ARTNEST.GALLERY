@extends('auth.layouts.authentication')

@section('content')
<!-- <div class="col-xxl-6 col-xl-9 col-lg-10 col-md-7 mx-auto py-lg-4">
    <h1 class="mb-5">{{ $title }}</h1>

    <div class="d-flex flex-column flex-md-row gap-4 justify-content-center">
        <div class="col-lg-6">
            <a href="{{ route('user.registration') }}"
            class="btn btn-light btn-lg px-5 py-3 border border-3 border-dark">
            {{ translate('Register as User') }}
        </a>
        </div>
        <div class="col-lg-6">
            <a href="{{ route('shops.create') }}"
            class="btn btn-light btn-lg px-5 py-3 border border-3 border-dark">
            {{ translate('Register as Seller') }}
            </a>
        </div>
    </div>
</div> -->
<div class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="container" style="max-width: 720px;">
        <h1 class="text-center text-dark mb-5 display-5 fw-bold">
            Choose Your Role
        </h1>

        <div class="row g-4">
            <!-- Seller Card -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-3 border-dark">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="bi bi-bag-fill fs-1 text-primary"></i>
                        </div>
                        <h5 class="card-title fw-bold">Seller</h5>
                        <p class="card-text">
                            Manage your products, track sales, and grow your business.
                        </p>
                        <a href="{{ route('shops.create') }}" class="btn btn-outline-primary w-100 mt-3">
                            Select Seller Role
                        </a>
                    </div>
                </div>
            </div>

            <!-- User Card -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-3 border-dark">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="bi bi-person-circle fs-1 text-info"></i>
                        </div>
                        <h5 class="card-title fw-bold">Buyer</h5>
                        <p class="card-text">
                            Browse products, make purchases, and manage your orders.
                        </p>
                        <a href="{{ route('user.registration') }}" class="btn btn-outline-info w-100 mt-3">
                            Select Buyer Role
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
