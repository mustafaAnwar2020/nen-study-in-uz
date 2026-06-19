<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

class AccessControlService
{
    /**
     * Permission group display labels for UI.
     * These map the group column in the permissions table to a display name.
     */
    public static function getPermissionGroups(): array
    {
        return [
            'dashboard'         => 'Dashboard',
            'offers'            => 'Offers',
            'blogs'             => 'Blogs',
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
            'general'           => 'General',
        ];
    }

    /**
     * Get permission display label from translation file or generate from name.
     */
    public static function getPermissionLabel(Permission $permission): string
    {
        $translation = __("permissions.{$permission->name}");
        // If translation returns the key itself, use name_ar or fall back to generated name
        if ($translation === "permissions.{$permission->name}") {
            return $permission->name_ar ?? $permission->name;
        }
        return $translation;
    }

    /**
     * Check if a user has a specific permission.
     * This is cached for the duration of the request for performance.
     */
    public static function userCan(User $user, string $permission): bool
    {
        static $cache = [];

        $key = $user->id . '_' . $permission;

        if (!isset($cache[$key])) {
            $cache[$key] = $user->hasPermissionTo($permission);
        }

        return $cache[$key];
    }

    /**
     * Ensure default roles exist (called from seeder).
     */
    public static function ensureDefaultRoles(): array
    {
        $roles = [];
        $defaults = [
            ['name' => 'super_admin', 'name_ar' => 'Super Admin', 'is_system' => true],
            ['name' => 'admin',       'name_ar' => 'Admin',        'is_system' => true],
            ['name' => 'editor',      'name_ar' => 'Editor',       'is_system' => false],
            ['name' => 'student',     'name_ar' => 'Student',      'is_system' => false],
            ['name' => 'instructor',  'name_ar' => 'Instructor',   'is_system' => false],
        ];

        foreach ($defaults as $data) {
            $roles[] = Role::firstOrCreate(
                ['name' => $data['name']],
                [
                    'name_ar'   => $data['name_ar'],
                    'is_system' => $data['is_system'],
                    'guard_name' => 'web',
                ]
            );
        }

        return $roles;
    }

    /**
     * Ensure all default permissions exist and assign all to super_admin.
     */
    public static function ensureDefaultPermissions(): void
    {
        $groups = self::getPermissionGroups();
        $superAdmin = Role::where('name', 'super_admin')->first();

        foreach ($groups as $group => $label) {
            // Find permissions that already exist for this group
            $perms = Permission::where('group', $group)->get();
            foreach ($perms as $permission) {
                if ($superAdmin && !$superAdmin->hasPermission($permission)) {
                    $superAdmin->givePermissionTo($permission);
                }
            }
        }
    }
}
