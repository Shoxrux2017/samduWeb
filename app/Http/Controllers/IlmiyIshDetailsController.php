<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScienceCategory;
use App\Models\PublishType;
use App\Models\PublishLevel;

use App\Models\NashrTiliModel;
use App\Models\UslubiyNashTuriModel;
use App\Models\OquvYiliModel;
use App\Models\NashrYiliModel;

class IlmiyIshDetailsController extends Controller
{
    public function scienceCategory()
    {
        $scienceCategory = ScienceCategory::all();

        return response()->json($scienceCategory);
    }

    public function publishType()
    {
        $publishType = PublishType::all();
        
        return response()->json($publishType);
    }

    public function publishLevel()
    {
        $publishLevel = PublishLevel::all();

        return response()->json($publishLevel);
    }

    public function nashrTili()
    {
        $nashrTili = NashrTiliModel::all();

        return response()->json($nashrTili);
    }

    public function uslubiyNashTuri()
    {
        $uslubiyNashTuri = UslubiyNashTuriModel::all();

        return response()->json($uslubiyNashTuri);
    }

    

    public function oquvYili()
    {
        $oquvYili = OquvYiliModel::all();

        return response()->json($oquvYili);
    }

    public function nashrYili()
    {
        $nashrYili = NashrYiliModel::all();

        return response()->json($nashrYili);
    }
}
