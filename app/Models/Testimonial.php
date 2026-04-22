<?php

namespace App\Models;

use App\Support\ImageAsset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote',
        'author',
        'role',
        'avatar',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function getAvatarUrlAttribute(): ?string
    {
        return ImageAsset::resolveNullable($this->avatar);
    }
}