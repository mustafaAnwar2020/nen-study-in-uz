<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Models\Permission;

class SeedPermission extends Seeder
{
    /**
     * Map of route name segments to display labels for permission groups.
     */
    protected $groupLabels = [
        'dashboard'         => 'Dashboard',
        'offers'            => 'Offers',
        'locations'         => 'Locations',
        'categories'        => 'Categories',
        'countries'         => 'Countries',
        'products'          => 'Products',
        'events'            => 'Events',
        'faqs'              => 'FAQs',
        'cefr'              => 'CEFR',
        'sliders'           => 'Sliders',
        'partners'          => 'Partners',
        'network'           => 'Network',
        'sections'          => 'Sections',
        'nen-landing-settings' => 'Homepage',
        'nen-landing-items' => 'NEN Landing Items',
        'tpi-section'       => 'TPI Sections',
        'tpi-hero-section'  => 'TPI Hero',
        'tpi-overview-section' => 'TPI Overview',
        'tpi-key-benefits-section' => 'TPI Key Benefits',
        'tpi-join-partner-section' => 'TPI Join Partner',
        'tpi-contact-section' => 'TPI Contact',
        'tpi-cta-section'   => 'TPI CTA',
        'tpi-faqs'          => 'TPI FAQs',
        'library'           => 'Library',
        'settings'          => 'Settings',
        'user_settings'     => 'User Settings',
        'histories'         => 'Histories',
        'contact-messages'  => 'Contact Messages',
        'event-requests'    => 'Event Requests',
        'newsletter'        => 'Newsletter',
        'users'             => 'Users',
        'roles'             => 'Roles',
        'permissions'       => 'Permissions',
        'notifications'     => 'Notifications',
        'file-system'       => 'File System',
        'protected-files'   => 'Protected Files',
    ];

    /**
     * Route names to skip (internal/non-resource routes).
     */
    protected $skipNames = [
        'admin.logout',
        'admin.logs',
        'admin.change_status',
        'admin.delete',
        'admin.update-passwords',
        'admin.',        // empty route prefix name
        'admin.network.', // trailing dot
    ];

    /**
     * Map specific route names to simpler permission names.
     * Key: route name, Value: desired permission name.
     */
    protected $nameOverrides = [
        'admin.dashboard' => 'dashboard.view',
        'admin.users.permissions' => 'permissions.edit',
        'admin.users.update_permissions' => 'permissions.edit',
        'admin.permissions.sync-default' => 'permissions.edit',
        'admin.settings.index' => 'settings.view',
        'admin.settings.update' => 'settings.update',
        'admin.user_settings.index' => 'user_settings.view',
        'admin.user_settings.update' => 'user_settings.update',
        'admin.contact-messages.mark-done' => 'contacts.manage',
        'admin.event-requests.mark-done' => 'event-requests.manage',
        'admin.event-requests.delete' => 'event-requests.manage',
        'admin.notifications.mark-all-read' => 'notifications.manage',
        'admin.file-system.preview' => 'files.view',
        'admin.file-system.download' => 'files.view',
        'admin.file-system.destroy'  => 'files.delete',
        'admin.file-system.refresh' => 'files.view',
        'admin.file-system.getDirectoryInfo' => 'files.view',
        'admin.protected-files.passwords' => 'files.view',
        'admin.protected-files.toggle-status' => 'files.edit',
        'admin.protected-files.update-password' => 'files.edit',
    ];

    /**
     * Map permission action verbs to display labels.
     */
    protected $actionLabels = [
        'index'   => 'List',
        'store'   => 'Create',
        'create'  => 'Create',
        'edit'    => 'Edit',
        'update'  => 'Edit',
        'show'    => 'View',
        'destroy' => 'Delete',
        'delete'  => 'Delete',
        'import'  => 'Import',
        'export'  => 'Export',
        'view'    => 'View',
        'manage'  => 'Manage',
    ];

    /**
     * Extract the group key from a route name by removing admin. prefix and the last segment.
     */
    protected function extractGroup(string $routeName): string
    {
        $withoutPrefix = preg_replace('/^admin\./', '', $routeName);
        $parts = explode('.', $withoutPrefix);
        array_pop($parts); // Remove the action part
        return implode('.', $parts) ?: 'general';
    }

    /**
     * Extract the action (last segment) from a route name.
     */
    protected function extractAction(string $routeName): string
    {
        $withoutPrefix = preg_replace('/^admin\./', '', $routeName);
        $parts = explode('.', $withoutPrefix);
        return end($parts);
    }

    /**
     * Generate a display label for a permission based on its name.
     */
    protected function generateLabel(string $permissionName): string
    {
        $parts = explode('.', $permissionName);
        $action = array_pop($parts);
        $actionLabel = $this->actionLabels[$action] ?? ucfirst($action);

        // Convert dashed/underscored segments to readable words
        $groupParts = [];
        foreach ($parts as $part) {
            $words = preg_split('/[-_\/]/', $part);
            $groupParts[] = implode(' ', array_map('ucfirst', $words));
        }
        $groupLabel = implode(' ', $groupParts);

        return $actionLabel . ' ' . $groupLabel;
    }

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Permission::query()->truncate();
        Schema::enableForeignKeyConstraints();

        $data = [];
        $seen = []; // Track permission names to avoid duplicates

        foreach (Route::getRoutes() as $route) {
            $routeName = $route->getName();

            // Skip routes without names or non-admin routes
            if (!$routeName || !str_starts_with($routeName, 'admin.')) {
                continue;
            }

            // Skip explicitly excluded routes
            if (in_array($routeName, $this->skipNames)) {
                continue;
            }

            // Determine the permission name (use override or generate from route)
            if (isset($this->nameOverrides[$routeName])) {
                $permissionName = $this->nameOverrides[$routeName];
                // Extract group from the override name instead
                $nameParts = explode('.', $permissionName);
                $group = count($nameParts) > 1 ? $nameParts[0] : 'general';
            } else {
                // Strip admin. prefix to get e.g. offers.index
                $permissionName = preg_replace('/^admin\./', '', $routeName);
                // Extract group from the route name
                $group = $this->extractGroup($routeName);
            }

            // Skip duplicates (multiple routes with same permission name)
            if (isset($seen[$permissionName])) {
                continue;
            }
            $seen[$permissionName] = true;

            // Generate Arabic label
            $label = $this->generateLabel($permissionName);

            $data[] = [
                'name'       => $permissionName,
                'name_ar'    => $label,
                'guard_name' => 'web',
                'group'      => $group,
            ];
        }

        // Sort by group then name for consistent display
        usort($data, function ($a, $b) {
            return strcmp($a['group'] . '.' . $a['name'], $b['group'] . '.' . $b['name']);
        });

        Permission::insert($data);

        // Assign all permissions to super_admin role
        $superAdmin = \App\Models\Role::where('name', 'super_admin')->first();
        if ($superAdmin) {
            $allIds = Permission::pluck('id')->toArray();
            $superAdmin->permissions()->sync($allIds);
        }

        $this->command->info('Permissions seeded successfully! Total: ' . count($data));
    }
}
