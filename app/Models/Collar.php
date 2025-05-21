<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collar extends Model
{
    protected $fillable = ['status', 'data_frequency'];

    public function cow()
    {
        return $this->belongsTo(Cow::class);
    }

    public function heartRateDatas()
    {
        return $this->hasMany(HeartRateData::class);
    }

    public function temperatureDatas()
    {
        return $this->hasMany(TemperatureData::class);
    }

    public function accelerometerDatas()
    {
        return $this->hasMany(AccelerometerData::class);
    }
}
