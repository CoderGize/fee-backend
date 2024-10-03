<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    use HasFactory;


    protected $fillable = [
        'img',
        'about_en',
        'about_ar',
        'vision_en',
        'vision_ar',
        'mission_en',
        'mission_ar',
        'whyus_title_en',
        'whyus_title_ar',
        'whyus_text_en',
        'whyus_text_ar',
    ];


    protected $casts = [
        'whyus_text_en' => 'json',
        'whyus_text_ar' => 'json',
    ];
}
