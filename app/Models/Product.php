<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'admin_id',
        'brand_id',
        'category_id',
        'unit_id',
        'name',
        'slug',
        'sku',
        'barcode',
        'image',
        'quantity',
        'quantity_alert',
        'purchase_price',
        'mrp',
        'selling_price',
        'discount',
        'discount_type',
        'tax_id',
        'tax_type',
        'short_description',
        'status',
    ];
    // product brands
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    // product category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    // product unit
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    // product tax
    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }

}
