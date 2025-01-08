<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NashrYiliModel extends Model
{
    use HasFactory;

    
    protected $table = 'nashr_yili';


    protected $fillable = [
        'nashr_yili',
    ];
}
