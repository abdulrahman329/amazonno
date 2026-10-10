<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'user_id', 'description', 'price', 'stock'])]
class Product extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
