<?php

namespace App\Services\NasaService;

use App\Models\NearEarthObject;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class Nasa
{
    private const DAYS_TO_UPDATE = 2;

    public function updateSpaceObjects()
    {
        $daysForUpdate = $this->getDaysForUpdate();
        $today = Carbon::now()->isoFormat('YYYY-MM-DD');
        $startDate = Carbon::now()->subDays($daysForUpdate)->isoFormat('YYYY-MM-DD');
        $response = Http::get(env("NASA_URL"), [
            'start_date' => $startDate,
            'end_date' => $today,
            'api_key' => env("NASA_API"),
        ]);
        if ($response->successful()) {
            $this->save($response['near_earth_objects']);
        }
    }

    public function needUpdate()
    {
        return $this->getDaysFromLastUpdate() > 0;
    }

    private function getDaysForUpdate()
    {
        $fromLastUpdate = $this->getDaysFromLastUpdate();

        //"today" it's plus one day
        return ($fromLastUpdate > self::DAYS_TO_UPDATE) ? self::DAYS_TO_UPDATE : $fromLastUpdate - 1;
    }

    public function checkForUpdate()
    {
        if ($this->needUpdate()) {
            $this->updateSpaceObjects();
        }
    }

    private function getDaysFromLastUpdate(): int
    {
        $lastObject = NearEarthObject::getLast();
        if (!isset($lastObject->date)) {
            //if it's first update, download from last 3 days
            return 3;
        }
        $lastObjectDay = new Carbon($lastObject->date);
        $today = Carbon::today();

        return $today->diffInDays($lastObjectDay);
    }

    private function save($nearEarthObjects)
    {
        foreach ($nearEarthObjects as $date => $objects) {
            foreach ($objects as $object) {
                $nearEarthObject = new NearEarthObject();
                $nearEarthObject->referenced = Arr::get($object, 'links.self', null);
                $nearEarthObject->name = Arr::get($object, 'name', null);
                $nearEarthObject->speed = Arr::get($object, 'close_approach_data.0.relative_velocity.kilometers_per_hour', null);
                $nearEarthObject->is_hazardous = Arr::get($object, 'is_potentially_hazardous_asteroid', null);
                $nearEarthObject->date = $date ?? null;
                $nearEarthObject->save();
            }
        }
    }
}
