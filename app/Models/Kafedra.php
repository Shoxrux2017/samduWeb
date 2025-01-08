<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Kafedra extends Model
{
    use HasFactory;

    protected $table = 'kafedra';
    protected $fillable = ['title', 'fakultet_id'];



    public function user()
{
    return $this->belongsToMany(User::class);
}
}
