<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return $this->is_admin;
    }

    /* -----------------------------------------------------------------
     | Role & Permission Relationships
     | ----------------------------------------------------------------- */

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function assignedEvents()
    {
        return $this->belongsToMany(Event::class, 'event_user');
    }

    public function directPermissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permission');
    }

    /**
     * Get all permission IDs for this user (via roles + direct).
     */
    public function getAllPermissionIds(): array
    {
        $roleIds = $this->roles()->pluck('roles.id');
        $viaRoles = \DB::table('role_permission')
            ->whereIn('role_id', $roleIds)
            ->pluck('permission_id')
            ->toArray();
        $direct = $this->directPermissions()->pluck('permissions.id')->toArray();
        return array_unique(array_merge($viaRoles, $direct));
    }

    /**
     * Get all permission names for this user.
     */
    public function getAllPermissionNames(): array
    {
        $ids = $this->getAllPermissionIds();
        return Permission::whereIn('id', $ids)->pluck('name')->toArray();
    }

    /**
     * Check if user has a specific permission.
     * Super admin bypasses all permission checks.
     */
    public function hasPermissionTo($permission): bool
    {
        // Super admin has all permissions implicitly
        if ($this->hasRole('super_admin')) {
            return true;
        }

        if (is_string($permission)) {
            return in_array($permission, $this->getAllPermissionNames(), true);
        }
        if ($permission instanceof Permission) {
            return in_array($permission->id, $this->getAllPermissionIds(), true);
        }
        return false;
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole($role): bool
    {
        if (is_string($role)) {
            return $this->roles()->where('name', $role)->exists();
        }
        if ($role instanceof Role) {
            return $this->roles()->where('id', $role->id)->exists();
        }
        return false;
    }

    /**
     * Scope: filter users by role name.
     */
    public function scopeRole($query, $role)
    {
        return $query->whereHas('roles', function ($q) use ($role) {
            $q->where('name', $role);
        });
    }

    /**
     * Assign a role to the user (replaces existing assignment).
     */
    public function assignRole($role): self
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->firstOrFail();
        }
        if ($role instanceof Role) {
            $this->roles()->sync([$role->id]);
        }
        return $this;
    }

    /**
     * Sync multiple roles (replaces all).
     */
    public function syncRoles(array $roles): self
    {
        $ids = [];
        foreach ($roles as $role) {
            if ($role instanceof Role) {
                $ids[] = $role->id;
            } else {
                $r = Role::where('name', (string)$role)->first();
                if ($r) $ids[] = $r->id;
            }
        }
        $this->roles()->sync($ids);
        return $this;
    }

    /**
     * Directly give a permission to the user (bypasses roles).
     */
    public function giveDirectPermission($permission): self
    {
        if (is_string($permission)) {
            $permission = Permission::firstOrCreate(
                ['name' => $permission],
                ['guard_name' => 'web']
            );
        }
        if (!$this->directPermissions()->where('id', $permission->id)->exists()) {
            $this->directPermissions()->attach($permission);
        }
        return $this;
    }

    /**
     * Revoke a direct permission from the user.
     */
    public function revokeDirectPermission($permission): self
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->first();
        }
        if ($permission) {
            $this->directPermissions()->detach($permission);
        }
        return $this;
    }

    /**
     * Sync direct permissions (replaces all direct permissions).
     */
    public function syncDirectPermissions(array $permissions): self
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
        $this->directPermissions()->sync($ids);
        return $this;
    }

    public function governorate(): BelongsTo
    {
        return $this->belongsTo(Governorate::class, 'address_governorate_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'address_city_id');
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class, 'address_village_id');
    }


    public function getGovernorate()
    {
        return $this->governorate->governorate_name_ar ?? '';
    }

    public function getCity()
    {
        return $this->city->city_name_ar ?? '';
    }

    public function getVillage()
    {
        return $this->village->name ?? '';
    }


    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function groups_ids_array()
    {
        return $this->groups()->pluck('group_id')->toArray();
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    public function assessmentsMadeByUser()
    {
        return $this->assessments()->whereNotNull('row_id');
    }

    public function assessmentsMadeByInstructorForUser()
    {
        return $this->assessments()->whereNull('row_id');
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(Certificate::class);
    }


    /**
     * Relation: user controlling governorates
     */
    public function controllingGovernorates()
    {
        return $this->belongsToMany(Governorate::class, 'governorate_user');
    }

    /**
     * Relation: user controlling governorates return city_ids array
     */
    public function controllingGovernoratesCityIds()
    {
        if ($this->address_city_id)
            return [$this->address_city_id];

        $governorate_ids = $this->controllingGovernorates()->pluck('governorate_id')->toArray();
        $city_ids = City::whereIn('governorate_id', $governorate_ids)->pluck('id');

        return $city_ids->toArray();
    }

    /**
     * Get all cities of a controlling users' governorate
     */
    public function controllingUserGovernorateCitiesIds(): array
    {
        if ($this->address_governorate_id) {
            return City::where('governorate_id', $this->address_governorate_id)->pluck('id')->toArray();
        };

        return [];
    }


    /**
     *  Return a collection of students whom their applications are accepted.
     */
    public static function getApprovedApplicationStudents()
    {
        $approved_students_ids = Application::whereStatus('approved')->pluck('user_id')->toArray();
        return User::role('student')->whereIn('id', $approved_students_ids)
            ->orderBy('id', 'desc');
    }

    /**
     *  Return a collection of employees
     */

    public static function getEmployeeUsers()
    {
        return self::with(['city', 'governorate', 'roles'])
            ->whereDoesntHave("roles", function ($q) {
                $q->where("name", "student")
                    ->orWhere("name", "instructor");
            })->orderBy('id', 'desc');
    }


    /**
     *  Return a collection of instructors
     */

    public static function getInstructors()
    {
        return self::role('instructor')->get();
    }

    public function changeRequests(): HasMany
    {
        return $this->hasMany(ChangeRequest::class, 'created_by');
    }


    // Instructor functions

    public function instructorCourse(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function instructorDocs(): HasMany
    {
        return $this->hasMany(InstructorDocument::class, 'user_id');
    }

    public function getInstructorDocByKey($key)
    {
        return $this->instructorDocs->where('key', $key)->first();
    }


}
