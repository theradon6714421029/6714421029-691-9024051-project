@extends('layouts.app')
@section('title', 'เมนูอาหาร')
@section('content')
<h3 class="mb-4 fw-semibold">เมนูอาหารทั้งหมด</h3>

<div class="row g-3">
    @forelse($menus as $menu)
        <div class="col-md-4">
            <div class="card food-card h-100">
                <a href="/menu/{{ $menu['id'] }}" class="text-decoration-none text-reset position-relative">
                    <img src="{{ $menu['image_url'] ?? 'https://placehold.co/400x300?text=No+Image' }}" class="card-img-top" alt="{{ $menu['name'] }}">
                    <span class="badge bg-dark bg-opacity-75 position-absolute top-0 start-0 m-2">{{ $menu['restaurant_name'] }}</span>
                </a>
                <div class="card-body d-flex flex-column">
                    <a href="/menu/{{ $menu['id'] }}" class="text-decoration-none text-reset">
                        <h5>{{ $menu['name'] }}</h5>
                    </a>
                    <p class="text-muted small flex-grow-1">{{ \Illuminate\Support\Str::limit($menu['description'] ?? '', 80) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="text-primary fs-5">฿{{ number_format($menu['price'], 2) }}</strong>
                        @if($menu['is_available'] ?? false)
                            <button class="btn btn-sm btn-primary rounded-pill px-3 add-to-cart-btn" data-menu-id="{{ $menu['id'] }}">
                                <i class="bi bi-cart-plus"></i> เพิ่ม
                            </button>
                        @else
                            <span class="badge bg-secondary">หมด</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">ไม่พบเมนูอาหาร</p>
    @endforelse
</div>
@endsection