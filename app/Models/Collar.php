<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collar extends Model
{
    protected $fillable = ['status', 'data_frequency'];

    public function cows()
    {
        return $this->belongsTo(Cow::class);
    }

    public function heartRateData()
    {
        return $this->hasMany(HeartRateData::class);
    }

    public function temperatureData()
    {
        return $this->hasMany(TemperatureData::class);
    }

    public function accelerometerData()
    {
        return $this->hasMany(AccelerometerData::class);
    }
}
