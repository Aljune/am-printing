<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'subcategory',
        'image_url',
        'image_path',
        'video_url',
        'video_path',
    ];

    protected $casts = [
        'price' => 'float',
    ];

    public function categoryLabel(): string
    {
        $cat = collect(config('catalog.categories'))->firstWhere('id', $this->category);
        return $cat['label'] ?? $this->category;
    }

    public function subcategoryLabel(): ?string
    {
        $cat = collect(config('catalog.categories'))->firstWhere('id', $this->category);
        if (!$cat || empty($cat['subcategories'])) return null;
        $sub = collect($cat['subcategories'])->firstWhere('id', $this->subcategory);
        return $sub['label'] ?? null;
    }
}
