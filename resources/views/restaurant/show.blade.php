@extends('layouts.app')
@section('title', $restaurant['name'] ?? 'ร้านอาหาร')
@section('content')
<div class="card hoverable mb-4">
    <img src="{{ $restaurant['image_url'] ?? 'https://placehold.co/600x300?text=No+Image' }}" class="card-img-hero" alt="{{ $restaurant['name'] }}">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
            <h2 class="mb-0">{{ $restaurant['name'] ?? '-' }}</h2>
            @if(($restaurant['is_open'] ?? false))
                <span class="badge bg-success fs-6">เปิดอยู่</span>
            @else
                <span class="badge bg-secondary fs-6">ปิดอยู่</span>
            @endif
        </div>
        <p class="text-muted mb-2">{{ $restaurant['description'] ?? '' }}</p>
        <div class="d-flex gap-3 text-muted small">
            <span><i class="bi bi-clock"></i> {{ $restaurant['open_time'] ?? '-' }} - {{ $restaurant['close_time'] ?? '-' }}</span>
            <span><i class="bi bi-geo-alt"></i> {{ $restaurant['address'] ?? '-' }}</span>
            <span><i class="bi bi-telephone"></i> {{ $restaurant['phone'] ?? '-' }}</span>
        </div>
    </div>
</div>

<h4 class="mb-3 fw-semibold">เมนูของร้านนี้</h4>
<div class="row g-3">
    @forelse($menus as $menu)
        <div class="col-md-4">
            <div class="card food-card h-100">
                <a href="/menu/{{ $menu['id'] }}" class="text-decoration-none text-reset">
                    <img src="{{ $menu['image_url'] ?? 'https://placehold.co/400x300?text=No+Image' }}" class="card-img-top" alt="{{ $menu['name'] }}">
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
        <p class="text-muted">ร้านนี้ยังไม่มีเมนู</p>
    @endforelse
</div>
@endsection