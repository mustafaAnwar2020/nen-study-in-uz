<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    public function hasPermission($permission): bool
    {
        if (is_string($permission)) {
            return $this->permissions()->where('name', $permission)->exists();
        }
        if ($permission instanceof Permission) {
            return $this->permissions()->where('id', $permission->id)->exists();
        }
        return false;
    }

    public function givePermissionTo($permission): self
    {
        if (is_string($permission)) {
            $permission = Permission::firstOrCreate(
                ['name' => $permission],
                ['guard_name' => 'web']
            );
        }
        if (!$this->hasPermission($permission)) {
            $this->permissions()->attach($permission);
        }
        return $this;
    }

    public function revokePermissionTo($permission): self
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->first();
        }
        if ($permission) {
            $this->permissions()->detach($permission);
        }
        return $this;
    }

    public function syncPermissions(array $permissions): self
    {
        $ids = [];
        foreach ($permissions as $perm) {
            if ($perm instanceof Permission) {
                $ids[] = $perm->id;
            } elseif (is_numeric($perm)) {
                $ids[] = (int) $perm;
            } else {
                $p = Permission::firstOrCreate(
                    ['name' => (string)$perm],
                    ['guard_name' => 'web']
                );
                $ids[] = $p->id;
            }
        }
        $this->permissions()->sync($ids);
        return $this;
    }
}
