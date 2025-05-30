<?php

namespace App\Models;

use App\Enums\CowStatus;
use Illuminate\Database\Eloquent\Model;

class Cow extends Model
{
    protected $fillable = [
        'name',
        'birth_date',
        'weight',
        'race',
        'cow_photos',
        'status',
        'tag',
        'farm_id',
        'collar_id'
    ];
    protected $casts = [
        'cow_photos' => 'array',
        'status' => CowStatus::class,
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class, 'farm_id');
    }

    public function collar()
    {
        return $this->belongsTo(Collar::class, 'collar_id');
    }

    public function heartRateDatas()
    {
        return $this->hasMany(HeartRateData::class, 'cow_id');
    }

    public function temperatureDatas()
    {
        return $this->hasMany(TemperatureData::class, 'cow_id');
    }
    public function accelerometerDatas()
    {
        return $this->hasMany(AccelerometerData::class, 'cow_id');
    }
}
