<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasUuids;
    protected $fillable=["title", "slug", "description", "image", "price", "discount", "status", "category_id" ];
    public function category(){
        return $this->belongsTo(Category::class, "category_id", "id");
    }
}

