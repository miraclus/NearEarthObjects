<?php

namespace App\Http\Controllers;

use App\Facades\NasaService;
use App\Models\NearEarthObject;
use Illuminate\Http\Request;

class NearEarthObjectController extends Controller
{
    public function getHazardous()
    {
        NasaService::checkForUpdate();

        $hazardsObjects = NearEarthObject::where('is_hazardous', 1)->get();

        return $hazardsObjects->toJson(JSON_UNESCAPED_SLASHES);
    }

    public function getFastest(Request $req)
    {
        NasaService::checkForUpdate();

        $hazardous = $req->boolean('hazardous');
        $fastestObjects = NearEarthObject::forLastThreeDays($hazardous);

        return $fastestObjects->toJson(JSON_UNESCAPED_SLASHES);
    }
}
