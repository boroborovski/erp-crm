<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Team;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Relaticle\SystemAdmin\Enums\SystemAdministratorRole;
use Relaticle\SystemAdmin\Models\SystemAdministrator;
use Throwable;

final class DockerSetupCommand extends Command
{
    protected $signature = 'relaticle:docker-setup';

    protected $description = 'Non-interactive first-boot setup for Docker deployments (idempotent)';

    public function handle(): int
    {
        $this->createSystemAdministrator();
        $this->createDefaultUser();

        return self::SUCCESS;
    }

    private function createSystemAdministrator(): void
    {
        if (SystemAdministrator::query()->exists()) {
            return;
        }

        $name = env('SYSADMIN_NAME', 'System Administrator');
        $email = env('SYSADMIN_EMAIL', 'sysadmin@relaticle.local');
        $password = env('SYSADMIN_PASSWORD', 'password');

        try {
            SystemAdministrator::query()->create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
                'role' => SystemAdministratorRole::SuperAdministrator,
            ]);

            $this->line('[docker-setup] System admin created: '.$email);
        } catch (Throwable $e) {
            $this->error('[docker-setup] Failed to create system admin: '.$e->getMessage());
        }
    }

    private function createDefaultUser(): void
    {
        if (User::query()->exists()) {
            return;
        }

        $name = env('ADMIN_NAME', 'Admin User');
        $email = env('ADMIN_EMAIL', 'admin@relaticle.local');
        $password = env('ADMIN_PASSWORD', 'password');
        $teamName = env('ADMIN_TEAM_NAME', 'My Team');

        try {
            $user = User::query()->create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]);

            $team = Team::query()->create([
                'name' => $teamName,
                'user_id' => $user->id,
                'personal_team' => true,
            ]);

            $user->ownedTeams()->save($team);
            $user->current_team_id = $team->id;
            $user->save();

            $this->line('[docker-setup] Default user created: '.$email);
        } catch (Throwable $e) {
            $this->error('[docker-setup] Failed to create default user: '.$e->getMessage());
        }
    }
}
