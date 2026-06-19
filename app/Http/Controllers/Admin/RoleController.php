<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $model = 'Role Management';
        $query = Role::query()->withCount('users', 'permissions')->orderBy('id');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%')
                ->orWhere('name_ar', 'like', '%' . $request->name . '%');
        }

        $rows = $query->paginate(20)->appends($request->all());

        return view('admin.roles.index', get_defined_vars());
    }

    public function create()
    {
        $model = 'Create Role';
        $permissionGroups = $this->getGroupedPermissions();
        return view('admin.roles.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:50|unique:roles,name',
            'name_ar'     => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create([
            'name'        => $request->name,
            'name_ar'     => $request->name_ar,
            'description' => $request->description,
            'guard_name'  => 'web',
            'is_system'   => false,
        ]);

        if ($request->filled('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $model = 'Edit Role';
        $role = Role::with('permissions')->findOrFail($id);
        $permissionGroups = $this->getGroupedPermissions();
        $rolePermissionIds = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:50|unique:roles,name,' . $id,
            'name_ar'     => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update([
            'name'        => $request->name,
            'name_ar'     => $request->name_ar,
            'description' => $request->description,
        ]);

        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if ($role->is_system) {
            return redirect()->back()
                ->with('error', 'System roles cannot be deleted.');
        }

        // Detach all users and permissions
        $role->users()->detach();
        $role->permissions()->detach();
        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }

    /**
     * Get permissions grouped by their group field for UI display.
     */
    private function getGroupedPermissions(): array
    {
        $permissions = Permission::orderBy('group')->orderBy('name')->get();
        $groups = [];

        foreach ($permissions as $perm) {
            $groupKey = $perm->group ?? 'other';
            if (!isset($groups[$groupKey])) {
                $groups[$groupKey] = [
                    'label'       => \App\Services\AccessControlService::getPermissionGroups()[$groupKey] ?? ucfirst($groupKey),
                    'permissions' => [],
                ];
            }
            $groups[$groupKey]['permissions'][] = $perm;
        }

        return $groups;
    }
}
