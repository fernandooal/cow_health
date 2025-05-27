<?php

namespace App\Models;

use App\Enums\CollarStatus;
use App\Enums\DataFrequency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collar extends Model
{
    protected $fillable = ['name', 'status', 'data_frequency'];
    protected $casts = [
        'status' => CollarStatus::class,
        'data_frequency' => DataFrequency::class
    ];

    public function cow()
    {
        return $this->hasOne(Cow::class, 'collar_id');
    }

    public function heartRateDatas()
    {
        return $this->hasMany(HeartRateData::class, 'collar_id');
    }

    public function temperatureDatas()
    {
        return $this->hasMany(TemperatureData::class, 'collar_id');
    }

    public function accelerometerDatas()
    {
        return $this->hasMany(AccelerometerData::class, 'collar_id');
    }
}
