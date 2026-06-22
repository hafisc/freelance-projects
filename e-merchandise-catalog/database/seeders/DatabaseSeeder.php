<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@cmb.dev',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_verified' => true,
        ]);

        User::create([
            'name' => 'Panitia',
            'email' => 'panitia@cmb.dev',
            'password' => Hash::make('password'),
            'role' => 'panitia',
            'is_verified' => true,
        ]);

        Category::create([
            'name' => 'Kaos',
            'slug' => 'kaos',
            'is_active' => true,
        ]);

        Category::create([
            'name' => 'Aksesoris',
            'slug' => 'aksesoris',
            'is_active' => true,
        ]);

        Banner::create([
            'title' => 'Selamat Datang di CMB Merch!',
            'description' => 'Temukan merchandise eksklusif Cresta Mandala Bhakti',
            'image' => 'banners/placeholder.svg',
            'is_active' => true,
            'order' => 1,
        ]);

        Product::create([
            'name' => 'Kaos CMB Hitam',
            'slug' => 'kaos-cmb-hitam',
            'description' => 'Kaos eksklusif Cresta Mandala Bhakti warna hitam',
            'image' => 'products/placeholder.svg',
            'price' => 150000,
            'type' => 'kaos',
            'sizes' => ['S', 'M', 'L', 'XL'],
            'stock' => 50,
            'category_id' => 1,
            'tags' => ['best seller', 'new'],
            'is_active' => true,
            'is_promo' => false,
        ]);

        Product::create([
            'name' => 'Kaos CMB Putih',
            'slug' => 'kaos-cmb-putih',
            'description' => 'Kaos eksklusif Cresta Mandala Bhakti warna putih',
            'image' => 'products/placeholder.svg',
            'price' => 150000,
            'promo_price' => 120000,
            'type' => 'kaos',
            'sizes' => ['S', 'M', 'L', 'XL'],
            'stock' => 30,
            'category_id' => 1,
            'tags' => ['promo'],
            'is_active' => true,
            'is_promo' => true,
        ]);

        Product::create([
            'name' => 'Topi CMB',
            'slug' => 'topi-cmb',
            'description' => 'Topi eksklusif Cresta Mandala Bhakti',
            'image' => 'products/placeholder.svg',
            'price' => 75000,
            'type' => 'non-kaos',
            'stock' => 100,
            'category_id' => 2,
            'is_active' => true,
            'is_promo' => false,
        ]);
    }
}
