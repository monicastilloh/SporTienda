<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model {
    protected $fillable = [
        'category_id','name','slug','description','price','stock','image','active'
    ];

    public function category() { return $this->belongsTo(Category::class); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }

    public function isAvailable(): bool { return $this->stock > 0 && $this->active; }

    protected static function boot() {
        parent::boot();
        static::creating(function ($product) {
            $product->slug = Str::slug($product->name) . '-' . uniqid();
        });
    }
}
