<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class UserManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user
                            {action=list : Action to perform (list|create|admin|reset-password)}
                            {--email= : User email address}
                            {--name= : User name (for create action)}
                            {--password= : New password (for create and reset-password actions)}
                            {--admin= : Set admin status (true/false)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage users - list, create, update admin status, reset passwords';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');

        return match ($action) {
            'list' => $this->listUsers(),
            'create' => $this->createUser(),
            'admin' => $this->toggleAdminStatus(),
            'reset-password' => $this->resetPassword(),
            default => $this->error("Unknown action: {$action}. Valid actions are: list, create, admin, reset-password")
        };
    }

    /**
     * List all users.
     *
     * @return int
     */
    protected function listUsers(): int
    {
        $users = User::all(['id', 'name', 'email', 'is_admin', 'created_at']);
        
        if ($users->isEmpty()) {
            $this->info('No users found.');
            return Command::SUCCESS;
        }
        
        $table = [];
        foreach ($users as $user) {
            $table[] = [
                $user->id,
                $user->name,
                $user->email,
                $user->is_admin ? 'Yes' : 'No',
                $user->created_at->format('Y-m-d H:i:s')
            ];
        }
        
        $this->table(
            ['ID', 'Name', 'Email', 'Admin', 'Created At'],
            $table
        );
        
        return Command::SUCCESS;
    }

    /**
     * Create a new user.
     *
     * @return int
     */
    protected function createUser(): int
    {
        $email = $this->option('email');
        $name = $this->option('name');
        $password = $this->option('password');
        $isAdmin = $this->option('admin') === 'true';
        
        if (!$email) {
            $email = $this->ask('Enter user email');
        }
        
        if (!$name) {
            $name = $this->ask('Enter user name');
        }
        
        if (!$password) {
            $password = $this->secret('Enter user password');
        }
        
        // Check if user already exists
        if (User::where('email', $email)->exists()) {
            $this->error("User with email {$email} already exists.");
            return Command::FAILURE;
        }
        
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->is_admin = $isAdmin;
        $user->save();
        
        $this->info("User {$user->name} created successfully with ID: {$user->id}");
        if ($isAdmin) {
            $this->info("User has been granted admin privileges.");
        }
        
        return Command::SUCCESS;
    }

    /**
     * Toggle admin status for a user.
     *
     * @return int
     */
    protected function toggleAdminStatus(): int
    {
        $email = $this->option('email');
        $adminStatus = $this->option('admin');
        
        if (!$email) {
            $email = $this->ask('Enter user email');
        }
        
        if ($adminStatus !== 'true' && $adminStatus !== 'false') {
            $adminStatus = $this->choice('Set user as admin?', ['true', 'false'], 0);
        }
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email {$email} not found.");
            return Command::FAILURE;
        }
        
        $user->is_admin = $adminStatus === 'true';
        $user->save();
        
        $this->info("User {$user->name} " . ($user->is_admin ? "is now an admin." : "is no longer an admin."));
        
        return Command::SUCCESS;
    }

    /**
     * Reset a user's password.
     *
     * @return int
     */
    protected function resetPassword(): int
    {
        $email = $this->option('email');
        $password = $this->option('password');
        
        if (!$email) {
            $email = $this->ask('Enter user email');
        }
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email {$email} not found.");
            return Command::FAILURE;
        }
        
        if (!$password) {
            $password = $this->secret('Enter new password');
            $confirmPassword = $this->secret('Confirm new password');
            
            if ($password !== $confirmPassword) {
                $this->error('Passwords do not match.');
                return Command::FAILURE;
            }
        }
        
        $user->password = Hash::make($password);
        $user->save();
        
        $this->info("Password for user {$user->name} has been reset.");
        
        return Command::SUCCESS;
    }
} 