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
    
    protected $appends = ['img_url'];

    public function getImgUrlAttribute()
    {
        return $this->img ? asset('storage/' . $this->img) : null;
    }

    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'item_category_id');
    }
}
