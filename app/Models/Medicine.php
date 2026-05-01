<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'stock',
        'price',
        'expiry_date',
        'category',
        'description',
        'supplier',
        'reorder_level',
        'image'
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'price' => 'decimal:2'
    ];

    // Add accessor for image URL
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-medicine.png'); // Default image
    }

    // Check if stock is low
    public function isLowStock()
    {
        return $this->stock <= $this->reorder_level;
    }

    // Check if near expiry (within 30 days)
    public function isNearExpiry()
    {
        return $this->expiry_date->diffInDays(now()) <= 30;
    }
}