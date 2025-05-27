<?php

namespace App\Models;

use App\Enums\CowStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'needs_treatment',
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
        return $this->collar->heartRateDatas();
    }

    public function temperatureDatas()
    {
        return $this->collar->temperatureDatas();
    }
    public function accelerometerDatas()
    {
        return $this->collar->accelerometerDatas();
    }
}
