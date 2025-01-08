<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UslubiyNashTuriModel extends Model
{
    use HasFactory;

    protected $table = 'uslubiy_nashr_turi';
    protected $fillable = [
        'nashr_turi',
    ];
}
