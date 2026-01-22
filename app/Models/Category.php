<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'admin_id',
        'name',
        'slug',
        'image',
        'status'
    ];
    // Relationship: Category has many SubCategories
    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }
}
