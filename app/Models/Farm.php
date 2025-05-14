<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{
    protected $fillable = [
        'cnpj',
        'name',
        'address',
        'phone',
        'email'
    ];

    public function cows()
    {
        return $this->hasMany(Cow::class);
    }
}

