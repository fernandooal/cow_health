<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    use HasFactory;

    protected $fillable = ['nome','descricao'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_group_permission');
    }
}
