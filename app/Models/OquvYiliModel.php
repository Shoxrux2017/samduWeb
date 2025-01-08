<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\IlmiyIsh;
class OquvYiliModel extends Model
{
    use HasFactory;


    protected $table = 'oquv_yili';


    protected $fillable = [
        'oquv_yili',
    ];


    // public function ilmiyIsh()
    // {
    //     return $this->hasMany(IlmiyIsh::class, 'study_year_id');
    // }

}
