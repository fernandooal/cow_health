<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cow extends Model
{
    protected $fillable = [
        'name',
        'birth_date',
        'weight',
        'race',
        'cow_photo',
        'needs_treatment',
        'farm_id',
        'collar_id'
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function collar()
    {
        return $this->hasOne(Collar::class);
    }
}
