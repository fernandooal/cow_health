<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorsData extends Model
{
    protected $fillable = [
        'cow_id',
        'collar_id',
        'model',
        'date_time',
        'type'
    ];

    public function cow()
    {
        return $this->belongsTo(Cow::class);
    }

    public function collar()
    {
        return $this->belongsTo(Collar::class);
    }

    public function heartRateData()
    {
        return $this->hasOne(HeartRateData::class);
    }

    public function temperatureData()
    {
        return $this->hasOne(TemperatureData::class);
    }

    public function accelerometerData()
    {
        return $this->hasOne(AccelerometerData::class);
    }
}
