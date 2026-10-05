@extends('layouts.app')
@section('title', 'จัดการร้าน')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-semibold mb-0">จัดการร้าน</h3>
    <button class="btn btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#resModal" onclick="openRestaurantModal()">
        <i class="bi bi-plus-lg"></i> เพิ่มร้าน
    </button>
</div>

<div class="row g-3" id="restaurantGrid">
    @foreach($restaurants as $res)
        <div class="col-md-4" data-id="{{ $res['id'] }}" data-name="{{ $res['name'] }}" data-description="{{ $res['description'] }}"
             data-open-time="{{ $res['open_time'] }}" data-close-time="{{ $res['close_time'] }}"
             data-address="{{ $res['address'] }}" data-phone="{{ $res['phone'] }}" data-is-open="{{ $res['is_open'] ? 1 : 0 }}">
            <div class="card hoverable h-100">
                <img src="{{ $res['image_url'] ?? 'https://placehold.co/400x300?text=No+Image' }}" class="card-img-top" alt="{{ $res['name'] }}">
                <div class="card-body">
                    <h6 class="fw-semibold">{{ $res['name'] }}</h6>
                    <span class="badge {{ $res['is_open'] ? 'bg-success' : 'bg-secondary' }}">{{ $res['is_open'] ? 'เปิดอยู่' : 'ปิดอยู่' }}</span>
                    <div class="mt-3 d-flex gap-2">
                        <button class="btn btn-sm btn-outline-secondary rounded-pill edit-restaurant-btn" data-bs-toggle="modal" data-bs-target="#resModal">แก้ไข</button>
                        <button class="btn btn-sm btn-outline-danger rounded-pill delete-restaurant-btn">ลบ</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="modal fade" id="resModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius:16px;border:none">
      <div class="modal-header border-0 pb-0"><h5 class="modal-title fw-semibold">ร้านอาหาร</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body p-4">
        <form id="restaurantForm" enctype="multipart/form-data">
          <input type="hidden" id="res_id">
          <div class="mb-3"><label class="form-label">ชื่อร้าน</label><input type="text" id="res_name" class="form-control" maxlength="150" required></div>
          <div class="mb-3"><label class="form-label">รายละเอียด</label><textarea id="res_description" class="form-control" maxlength="2000"></textarea></div>
          <div class="row g-2 mb-3">
            <div class="col"><label class="form-label">เวลาเปิด</label><input type="time" id="res_open_time" class="form-control" required></div>
            <div class="col"><label class="form-label">เวลาปิด</label><input type="time" id="res_close_time" class="form-control" required></div>
          </div>
          <div class="mb-3"><label class="form-label">ที่อยู่</label><input type="text" id="res_address" class="form-control" maxlength="300"></div>
          <div class="mb-3"><label class="form-label">เบอร์โทร</label><input type="text" id="res_phone" class="form-control" maxlength="20"></div>
          <div class="mb-3"><label class="form-label">รูปภาพ</label><input type="file" id="res_image" class="form-control" accept="image/png,image/jpeg,image/webp"></div>
          <div class="form-check mb-4"><input type="checkbox" id="res_is_open" class="form-check-input" checked><label class="form-check-label">เปิดร้านอยู่</label></div>
          <button class="btn btn-primary w-100 rounded-pill py-2">บันทึก</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')<script src="/js/admin-restaurants.js"></script>@endsection