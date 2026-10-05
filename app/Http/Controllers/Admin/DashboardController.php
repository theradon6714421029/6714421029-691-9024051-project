<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;

class DashboardController extends Controller
{
    public function __construct(protected FirebaseService $firebase) {}

    public function index()
    {
        $pendingOrders = $this->firebase->all('orders', [['status', '=', 'pending']]);
        $preparingOrders = $this->firebase->all('orders', [['status', '=', 'preparing']]);
        $menus = $this->firebase->all('menus');
        $categories = $this->firebase->all('categories');

        $stats = [
            'pending_count'   => count($pendingOrders),
            'preparing_count' => count($preparingOrders),
            'menu_count'      => count($menus),
            'category_count'  => count($categories),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function menus()
    {
        $menus = $this->firebase->all('menus');
        $categories = $this->firebase->all('categories', [], 'sort_order');
        $restaurants = $this->firebase->all('restaurants');
        return view('admin.menus.index', compact('menus', 'categories', 'restaurants'));
    }

    public function categories()
    {
        $categories = $this->firebase->all('categories', [], 'sort_order');
        return view('admin.categories.index', compact('categories'));
    }
    public function restaurants()
    {
    $restaurants = $this->firebase->all('restaurants');
    return view('admin.restaurants.index', compact('restaurants'));
    }
}
