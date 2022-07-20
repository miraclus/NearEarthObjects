<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class NearEarthObject extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
    protected $table = 'nearearthobject';

    public function scopeGetLast($query)
    {
        return $query->orderBy('date', 'DESC')->first();
    }

    public function scopeForLastThreeDays($query, $hazardous)
    {
        $today = Carbon::now()->isoFormat('YYYY-MM-DD');
        $twoDaysAgo = Carbon::now()->subDays(2)->isoFormat('YYYY-MM-DD');

        return $query->where('is_hazardous', $hazardous)
            ->where('date', '>=', $twoDaysAgo)
            ->where('date', '<=', $today)
            ->orderBy('speed', 'DESC')
            ->get();
    }
}
