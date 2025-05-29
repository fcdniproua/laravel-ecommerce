<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

/**
 * Заполняет базу данных тестовыми товарами
 */
class ProductSeeder extends Seeder
{
    /**
     * @var array<int, array<string, mixed>>
     */
    private array $products = [
        [
            'name' => 'iPhone 14 Pro',
            'description' => 'Флагманский смартфон Apple с продвинутой камерой и процессором A16 Bionic',
            'price' => 39999.99,
            'stock' => 15,
            'sku' => 'IPH14PRO-128-BLK',
            'image' => 'products/iphone14pro.jpg',
            'is_active' => true,
        ],
        [
            'name' => 'Samsung Galaxy S23 Ultra',
            'description' => 'Премиальный Android-смартфон с S Pen и мощной 200MP камерой',
            'price' => 45999.99,
            'stock' => 10,
            'sku' => 'SAMS23U-256-GRN',
            'image' => 'products/s23ultra.jpg',
            'is_active' => true,
        ],
        [
            'name' => 'MacBook Air M2',
            'description' => 'Ультратонкий ноутбук с процессором M2 и отличной автономностью',
            'price' => 49999.99,
            'stock' => 8,
            'sku' => 'MBA-M2-256-SLV',
            'image' => 'products/macbookair.jpg',
            'is_active' => true,
        ],
        [
            'name' => 'iPad Air 5',
            'description' => 'Мощный планшет с процессором M1 и поддержкой Apple Pencil 2',
            'price' => 24999.99,
            'stock' => 20,
            'sku' => 'IPAD-AIR5-64-BLU',
            'image' => 'products/ipadair.jpg',
            'is_active' => true,
        ],
        [
            'name' => 'AirPods Pro 2',
            'description' => 'Беспроводные наушники с активным шумоподавлением и пространственным звуком',
            'price' => 8999.99,
            'stock' => 30,
            'sku' => 'APP2-WHT',
            'image' => 'products/airpodspro.jpg',
            'is_active' => true,
        ],
        [
            'name' => 'Apple Watch Series 8',
            'description' => 'Умные часы с датчиком температуры и расширенными функциями здоровья',
            'price' => 14999.99,
            'stock' => 12,
            'sku' => 'AWS8-45-BLK',
            'image' => 'products/watch8.jpg',
            'is_active' => true,
        ],
        [
            'name' => 'PlayStation 5',
            'description' => 'Игровая консоль нового поколения с поддержкой 4K и трассировкой лучей',
            'price' => 19999.99,
            'stock' => 5,
            'sku' => 'PS5-DISC',
            'image' => 'products/ps5.jpg',
            'is_active' => true,
        ],
        [
            'name' => 'DJI Mini 3 Pro',
            'description' => 'Компактный дрон с 4K камерой и отличным временем полёта',
            'price' => 29999.99,
            'stock' => 7,
            'sku' => 'DJI-M3P',
            'image' => 'products/djimini3.jpg',
            'is_active' => true,
        ],
        [
            'name' => 'DJI Mini 4 Pro',
            'description' => 'Компактный дрон с 4K камерой и отличным временем полёта',
            'price' => 29999.99,
            'stock' => 7,
            'sku' => 'DJI-M4P',
            'image' => 'products/djimini4.jpg',
            'is_active' => true,
        ],
        [
            'name' => 'Sony WH-1000XM5',
            'description' => 'Премиальные наушники с лучшим в классе шумоподавлением',
            'price' => 12999.99,
            'stock' => 15,
            'sku' => 'SONY-WH1000XM5-BLK',
            'image' => 'products/sony1000xm5.jpg',
            'is_active' => true,
        ],
        [
            'name' => 'GoPro HERO11 Black',
            'description' => 'Экшн-камера с стабилизацией HyperSmooth 5.0 и 5.3K видео',
            'price' => 15999.99,
            'stock' => 10,
            'sku' => 'GPRO-H11B',
            'image' => 'products/gopro11.jpg',
            'is_active' => true,
        ],
        [
            'name' => 'GoPro HERO12 Black',
            'description' => 'Экшн-камера с стабилизацией HyperSmooth 5.0 и 5.3K видео',
            'price' => 15999.99,
            'stock' => 10,
            'sku' => 'GPRO-H12B',
            'image' => 'products/gopro12.jpg',
            'is_active' => true,
        ],
    ];

    public function run(): void
    {
        foreach ($this->products as $product) {
            Product::create($product);
        }
    }
}
