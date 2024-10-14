<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'img',
        'profile',
        'link',
        'name_en',
        'name_ar',
        'title_en',
        'title_ar',
        'date',
        'content_ar_1',
        'content_en_1',
        'content_ar_2',
        'content_en_2',
        'sub_title_ar',
        'sub_title_en',
        'blog_images',
    ];

    protected $casts = [
        'blog_images' => 'array',
    ];
}
