<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class FavouriteBooks extends Model
{
    use HasFactory;

    protected $table = 'favourite_books';
    protected $fillable = ['user_id', 'book_id', 'book_description', 'book_title', 'image_url', 'publish_date', 'publisher', 'is_fav'];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
