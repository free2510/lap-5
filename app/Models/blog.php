<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class blog extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'content',
        'users_id',
        'categories_id',
        'image',
        'tags',
    ];
    public function user(){
        return $this->belongsTo(Users::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }

}
