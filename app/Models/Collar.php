<?php

namespace App\Models;

use App\Enums\CollarStatus;
use App\Enums\DataFrequency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collar extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'status', 'data_frequency'];
    protected $casts = [
        'status' => CollarStatus::class,
        'data_frequency' => DataFrequency::class
    ];

    public function cow()
    {
        return $this->hasOne(Cow::class, 'collar_id');
    }
}
