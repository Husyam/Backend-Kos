<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'name_owner', 'no_kontak', 'category_gender' ,'price', 'description', 'stock','address', 'longitude', 'latitude', 'image', 'multi_image','id_category', 'fasilitas'];
    protected $attributes = [
        'fasilitas' => '[]', // Set default value for fasilitas to an empty array
    ];

    protected $primaryKey = 'id_product';


    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');

    }

}
