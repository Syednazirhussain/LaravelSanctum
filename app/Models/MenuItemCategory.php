<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItemCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'img',
    ];

    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'item_category_id');
    }
}
