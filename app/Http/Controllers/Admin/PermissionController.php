<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Services\AccessControlService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $model = 'Permission Management';

        $query = Permission::query()->withCount('roles', 'users')->orderBy('group')->orderBy('name');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('group')) {
            $query->where('group', $request->group);
        }

        $rows = $query->paginate(50)->appends($request->all());
        $groups = AccessControlService::getPermissionGroups();

        return view('admin.permissions.index', get_defined_vars());
    }

    public function create()
    {
        $model = 'Create Permission';
        $groups = AccessControlService::getPermissionGroups();
        return view('admin.permissions.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100|unique:permissions,name',
            'name_ar' => 'nullable|string|max:100',
            'group'   => 'nullable|string|max:50',
        ]);

        Permission::create([
            'name'       => $request->name,
            'name_ar'    => $request->name_ar,
            'group'      => $request->group,
            'guard_name' => 'web',
        ]);

        // Also sync to super_admin
        $superAdmin = \App\Models\Role::where('name', 'super_admin')->first();
        if ($superAdmin) {
            $superAdmin->givePermissionTo($request->name);
        }

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission created successfully.');
    }

    public function edit($id)
    {
        $model = 'Edit Permission';
        $permission = Permission::findOrFail($id);
        $groups = AccessControlService::getPermissionGroups();
        return view('admin.permissions.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name'    => 'required|string|max:100|unique:permissions,name,' . $id,
            'name_ar' => 'nullable|string|max:100',
            'group'   => 'nullable|string|max:50',
        ]);

        $permission->update([
            'name'    => $request->name,
            'name_ar' => $request->name_ar,
            'group'   => $request->group,
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully.');
    }

    public function syncDefaultPermissions()
    {
        AccessControlService::ensureDefaultPermissions();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Default permissions synchronized successfully.');
    }
}
