<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class OquvUslubiyIshModel extends Model
{
    use HasFactory;

    protected $table = 'oquv_uslubiy_ish';
    protected $fillable = [
        'user_id',
        'uslubiy_nashr_turi',
        'uslubiy_nashr_tili',
        'uslubiy_nashr_nomi',
        'mualliflar_soni',
        'mualliflar',
        'nashriyot',
        'nashr_parametrlari',
        'nashr_yili',
        'guvohnoma_raqami',
        'guvohnoma_sanasi',
        'oquv_yili',
        'file_path',
    ];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
