<?php

namespace App\Providers;

use App\Auth\FirestoreUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Auth::provider('firestore', function ($app, array $config) {
            return $app->make(FirestoreUserProvider::class);
        });

        // สร้าง symlink public/storage อัตโนมัติ (Railway ข้าม composer scripts ตอน build)
        if (! file_exists(public_path('storage'))) {
            try {
                app('files')->link(storage_path('app/public'), public_path('storage'));
        } catch (\Throwable $e) {
            // ไม่ให้เว็บล่มถ้าสร้างไม่ได้
        }
        }
    }
}