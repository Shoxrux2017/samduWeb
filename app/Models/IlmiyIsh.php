<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ScienceCategory;
use App\Models\PublishType;
use App\Models\PublishLevel;
use App\Models\PublishLanguage;
use App\Models\StudyYear;
class IlmiyIsh extends Model
{
    use HasFactory;

    protected $table = 'ilmiy_ish';
    protected $fillable = [
        'title',
        'science_category_id',
        'publish_type_id',
        'publish_level_id',
        'publish_language_id',
        'study_year_id',
        'user_id',
        'publish',
        'year',
        'page',
        'author',
        'coAuthor',
        'authorCount',
        'doi',
        'file_path',
    ];


    public function scienceCategory()
    {
        return $this->belongsTo(ScienceCategory::class,'science_category_id');
    }

    public function publishType()
    {
        return $this->belongsTo(PublishType::class,'publish_type_id');
    }

    public function publishLevel()
    {
        return $this->belongsTo(PublishLevel::class,'publish_level_id');
    }

    public function publishLanguage()
    {
        return $this->belongsTo(PublishLanguage::class,'publish_language_id');
    }

    public function studyYear()
    {
        return $this->belongsTo(StudyYear::class,'study_year_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
