<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'slug'
    ];

    public function parent(): BelongsTo
    {
       return $this->belongsTo(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
