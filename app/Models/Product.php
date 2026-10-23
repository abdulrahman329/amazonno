<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'user_id','category_id','description', 'price', 'stock'])]
class Product extends Model
{

    public function getCoverImageUrlAttribute(): ?string
{
    $path = $this->cover?->path;

    return $path ? asset('storage/' . $path) : null;
}

public function getImageUrlsAttribute(): array
{
    return $this->images
        ->map(fn (ProductImage $image) => asset('storage/' . $image->path))
        ->all();
}

    public function cover()
    {
        return $this->hasOne(ProductImage::class)->oldestOfMany('sort_order');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
