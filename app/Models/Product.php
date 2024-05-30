<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'name_owner', 'no_kontak', 'price', 'description', 'stock', 'longitude', 'latitude', 'image', 'category_id',];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
