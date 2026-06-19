<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $model = 'User Management';

        $query = User::with('roles')
            ->whereDoesntHave('roles', function ($q) {
                $q->whereIn('name', ['super_admin']);
            })

            ->orderBy('id', 'desc');

        // Filters
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('username')) {
            $query->where('username', 'like', '%' . $request->username . '%');
        }
        if ($request->filled('role_id')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('id', $request->role_id);
            });
        }

        $rows = $query->paginate(20)->appends($request->all());
        $roles = Role::whereNotIn('name', ['super_admin'])->get();

        return view('admin.users.index', get_defined_vars());
    }

    public function create()
    {
        $model = 'Create User';
        $roles = Role::whereNotIn('name', ['super_admin'])->get();
        return view('admin.users.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email'    => 'nullable|email|max:255',
            'password' => 'required|string|min:6',
            'role_id'  => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);

        // Assign the role
        $user->assignRole(Role::find($request->role_id));

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $model = 'Edit User';
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::whereNotIn('name', ['super_admin'])->get();
        $events = Event::orderBy('name')->get(['id', 'name']);
        $userEventIds = $user->assignedEvents()->pluck('event_id')->toArray();

        return view('admin.users.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'nullable|email|max:255',
            'password' => 'nullable|string|min:6',
            'role_id'  => 'required|exists:roles,id',
            'events'   => 'nullable|array',
            'events.*' => 'exists:events,id',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // Sync the role (single role per user in this design)
        $user->assignRole(Role::find($request->role_id));

        // Sync assigned events
        $user->assignedEvents()->sync($request->events ?? []);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return redirect()->back()
                ->with('error', 'You cannot delete your own account.');
        }

        // Prevent deleting super_admin
        if ($user->hasRole('super_admin')) {
            return redirect()->back()
                ->with('error', 'Super Admin account cannot be deleted.');
        }

        $user->roles()->detach();
        $user->directPermissions()->detach();
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Show permissions page for a specific user.
     */
    public function permissions($id)
    {
        $model = 'User Permissions';
        $user = User::with('roles.permissions')->findOrFail($id);

        $all_permissions = \App\Models\Permission::orderBy('group')->orderBy('name')->get();
        $user_permissions = $user->getAllPermissionIds();

        return view('admin.users.permissions', get_defined_vars());
    }

    /**
     * Update direct permissions for a user via AJAX.
     */
    public function updatePermissions(Request $request)
    {
        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $user = User::findOrFail($request->user_id);

        if ($user->hasRole('super_admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Super Admin already has all permissions.',
            ], 403);
        }

        $user->syncDirectPermissions($request->permissions ?? []);

        return response()->json([
            'success' => true,
            'message' => 'Permissions updated successfully.',
        ]);
    }
}
