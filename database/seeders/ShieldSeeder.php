<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ================================================================
        // PERMISSIONS — Core starter pack
        // Tambahkan permission baru sesuai resource project Anda
        // Format: {Action}:{Resource}
        // ================================================================
        $permissions = [
            // ── User ──────────────────────────────────────────────────
            'ViewAny:User',
            'View:User',
            'Create:User',
            'Update:User',
            'Delete:User',
            'Restore:User',
            'RestoreAny:User',
            'Replicate:User',
            'Reorder:User',
            'ForceDelete:User',
            'ForceDeleteAny:User',

            // ── Role ──────────────────────────────────────────────────
            'ViewAny:Role',
            'View:Role',
            'Create:Role',
            'Update:Role',
            'Delete:Role',
            'DeleteAny:Role',

            // ── Activity Log ──────────────────────────────────────────
            'ViewAny:Activity',
            'View:Activity',

            // ── Pages & Widgets ───────────────────────────────────────
            'page_Dashboard',
            'widget_StatsOverviewWidget',
            'widget_LatestActivitiesWidget',
            'widget_AccountWidget',
            'widget_FilamentInfoWidget',
        ];

        // Buat semua permission
        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => trim($permissionName)]);
        }

        $this->command->info('✅ ' . count($permissions) . ' permissions berhasil dibuat.');

        // ================================================================
        // ROLES
        // ================================================================
        $roles = [

            // ────────────────────────────────────────────────────────────
            // SUPER ADMIN — bypass semua gate via AppServiceProvider
            // Gate::before → return true untuk role ini
            // ────────────────────────────────────────────────────────────
            [
                'name'        => 'super_admin',
                'description' => 'Super Administrator dengan akses penuh ke seluruh sistem.',
                'permissions' => ['*'],
            ],

            // ────────────────────────────────────────────────────────────
            // ADMIN — kelola user & role, tidak bisa hapus role & force delete user
            // ────────────────────────────────────────────────────────────
            [
                'name'        => 'admin',
                'description' => 'Administrator — kelola user dan role, tidak bisa hapus role atau force delete user.',
                'permissions' => [
                    'ViewAny:User', 'View:User', 'Create:User', 'Update:User',
                    'Delete:User', 'Restore:User', 'RestoreAny:User',
                    'ViewAny:Role', 'View:Role',
                    'ViewAny:Activity', 'View:Activity',
                    'page_Dashboard',
                    'widget_StatsOverviewWidget',
                    'widget_LatestActivitiesWidget',
                    'widget_AccountWidget',
                ],
            ],

            // ────────────────────────────────────────────────────────────
            // MEMBER — hanya akses dashboard & profil sendiri
            // ────────────────────────────────────────────────────────────
            [
                'name'        => 'member',
                'description' => 'Member — akses terbatas hanya pada dashboard dan profil sendiri.',
                'permissions' => [
                    'page_Dashboard',
                    'widget_AccountWidget',
                    'widget_StatsOverviewWidget',
                ],
            ],
        ];

        foreach ($roles as $roleData) {
            $roleName = trim((string) ($roleData['name'] ?? ''));
            if (empty($roleName)) continue;

            $role = Role::firstOrCreate(
                ['name' => $roleName],
                ['name' => $roleName, 'guard_name' => 'web']
            );

            if (!empty($roleData['description'])) {
                $role->update(['description' => $roleData['description']]);
            }

            // Assign permissions
            if (in_array('*', $roleData['permissions'] ?? [])) {
                $role->syncPermissions(Permission::all()->pluck('name')->toArray());
                $count = Permission::count();
            } else {
                $perms = array_values(array_filter(
                    $roleData['permissions'] ?? [],
                    fn($p) => is_string($p) && !empty(trim($p))
                ));
                $role->syncPermissions($perms);
                $count = count($perms);
            }

            $this->command->info("  → Role [{$roleName}]: {$count} permissions.");
        }

        $this->command->info('✅ Shield Seeding Completed.');
    }
}
