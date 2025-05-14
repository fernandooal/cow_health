<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collar extends Model
{
    protected $fillable = ['status', 'data_frequency'];

    public function cows()
    {
        return $this->hasMany(Cow::class);
    }

    public function sensorsData()
    {
        return $this->hasMany(SensorsData::class);
    }
}
