<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['name', 'slug', 'price', 'description'];
    protected $casts = ['created_at' => 'date:d-m-Y H:i:s',];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    protected $appends = ['new_price'];

    public function getNewPriceAttribute()
    {
        return number_format((double)$this->price * 1.18, 2, '.', '');
    }
}
