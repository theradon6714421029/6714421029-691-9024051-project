<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function __construct(protected FirebaseService $firebase) {}

    /** หน้าแรก: รายการร้านทั้งหมด */
    public function index()
    {
        $restaurants = $this->firebase->all('restaurants');
        return view('restaurant.index', compact('restaurants'));
    }

    /** หน้าร้าน: ข้อมูลร้าน + เมนูของร้านนี้เท่านั้น */
    public function show(string $id)
    {
        $restaurant = $this->firebase->find('restaurants', $id);
        if (!$restaurant) {
            abort(404, 'ไม่พบร้านนี้');
        }

        $menus = $this->firebase->all('menus', [['restaurant_id', '=', $id]]);
        $categories = $this->firebase->all('categories', [], 'sort_order');

        return view('restaurant.show', compact('restaurant', 'menus', 'categories'));
    }

    /** เฉพาะ admin: เพิ่มร้านใหม่ */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:2000'],
            'is_open'     => ['required', 'boolean'],
            'open_time'   => ['required', 'date_format:H:i'],
            'close_time'  => ['required', 'date_format:H:i'],
            'address'     => ['nullable', 'string', 'max:300'],
            'phone'       => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s]*$/'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

         $data['name'] = strip_tags($data['name']);
        $data['description'] = strip_tags($data['description'] ?? '');
        $data['address'] = strip_tags($data['address'] ?? '');
        $data['image_url'] = $request->hasFile('image')
            ? \Illuminate\Support\Facades\Storage::url($request->file('image')->store('restaurant-images', 'public'))
            : null;
        unset($data['image']);

        $id = $this->firebase->create('restaurants', $data);

        return response()->json(['id' => $id, 'message' => 'เพิ่มร้านสำเร็จ'], 201);
    }

    /** เฉพาะ admin: แก้ไขร้าน */
    public function update(Request $request, string $id)
    {
        if (!$this->firebase->find('restaurants', $id)) {
            abort(404, 'ไม่พบร้านนี้');
        }

        $data = $request->validate([
            'name'        => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:2000'],
            'is_open'     => ['required', 'boolean'],
            'open_time'   => ['required', 'date_format:H:i'],
            'close_time'  => ['required', 'date_format:H:i'],
            'address'     => ['nullable', 'string', 'max:300'],
            'phone'       => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s]*$/'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $data['name'] = strip_tags($data['name']);
        $data['description'] = strip_tags($data['description'] ?? '');
        $data['address'] = strip_tags($data['address'] ?? '');

        if ($request->hasFile('image')) {
            $data['image_url'] = \Illuminate\Support\Facades\Storage::url($request->file('image')->store('restaurant-images', 'public'));
        }
        unset($data['image']);

        $this->firebase->update('restaurants', $id, $data);

        return response()->json(['message' => 'แก้ไขร้านสำเร็จ']);
    }

    /** เฉพาะ admin: ลบร้าน */
    public function destroy(string $id)
    {
        if (!$this->firebase->find('restaurants', $id)) {
            abort(404, 'ไม่พบร้านนี้');
        }

        $menusInRestaurant = $this->firebase->all('menus', [['restaurant_id', '=', $id]], null, 1);
        if (count($menusInRestaurant) > 0) {
            abort(409, 'ไม่สามารถลบได้ เนื่องจากยังมีเมนูอยู่ในร้านนี้');
        }

        $this->firebase->delete('restaurants', $id);
        return response()->json(['message' => 'ลบร้านสำเร็จ']);
    }
}