<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\IlmiyIsh;
class NashrTiliModel extends Model
{
    use HasFactory;
    protected $table = 'nashr_tili';
    protected $fillable = [
        'nashr_tili',
    ];


    // public function ilmiyIsh()
    // {
    //     return $this->hasMany(IlmiyIsh::class,'publish_language_id');
    // }

}
