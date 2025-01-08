<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\IlmiyIsh;
class PublishLevel extends Model
{
    use HasFactory;
    protected $table = 'publish_level';
    protected $fillable = [
        'title',
    ];


    public function ilmiyIsh()
    {
        return $this->hasMany(IlmiyIsh::class,'publish_level_id');
    }

}
