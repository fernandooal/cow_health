<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use \Spatie\Permission\Models\Permission as ModelsPermission;


class Permission extends ModelsPermission
{
    use HasFactory;
    protected $table = 'permissions';
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions', 'permission_id', 'role_id');
    }
    public function permissionGroups(): BelongsToMany
    {
        return $this->belongsToMany(PermissionGroup::class, 'permission_group_permission');
    }
    protected static function booted()
    {
        static::deleting(function ($permission) {
            $permission->permissionGroups()->detach();
        });
    }

}
