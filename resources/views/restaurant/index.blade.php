@extends('layouts.app')
@section('title', 'ร้านอาหารทั้งหมด')
@section('content')
<h3 class="mb-4 fw-semibold">ร้านอาหารทั้งหมด</h3>

<div class="row g-3">
    @forelse($restaurants as $restaurant)
        <div class="col-md-4">
            <a href="/restaurants/{{ $restaurant['id'] }}" class="text-decoration-none text-reset">
                <div class="card hoverable h-100">
                    <img src="{{ $restaurant['image_url'] ?? 'https://placehold.co/400x300?text=No+Image' }}" class="card-img-top" alt="{{ $restaurant['name'] }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <h5 class="mb-0">{{ $restaurant['name'] }}</h5>
                            @if($restaurant['is_open'] ?? false)
                                <span class="badge bg-success">เปิดอยู่</span>
                            @else
                                <span class="badge bg-secondary">ปิดอยู่</span>
                            @endif
                        </div>
                        <p class="text-muted small mb-1">{{ \Illuminate\Support\Str::limit($restaurant['description'] ?? '', 70) }}</p>
                        <small class="text-muted"><i class="bi bi-clock"></i> {{ $restaurant['open_time'] ?? '-' }} - {{ $restaurant['close_time'] ?? '-' }}</small>
                    </div>
                </div>
            </a>
        </div>
    @empty
        <p class="text-muted">ยังไม่มีร้านอาหารในระบบ</p>
    @endforelse
</div>
@endsection