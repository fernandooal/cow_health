<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
    use HasFactory;
    protected $table = 'roles';

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'model_has_roles','role_id','model_id');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class,'role_has_permissions','role_id','permission_id',);
    }


}
