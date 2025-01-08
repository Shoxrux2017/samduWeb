<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\IlmiyIsh;


class ScienceCategory extends Model
{
    use HasFactory;
    
    protected $table = 'science_category';
    protected $fillable = [
        'title',
    ];


    public function ilmiyIsh()
    {
        return $this->hasMany(IlmiyIsh::class,'science_category_id');
    }


}
