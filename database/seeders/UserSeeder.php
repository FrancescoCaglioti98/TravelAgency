<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory(['email' => 'admin@admin.com'])->create();
        $user->roles()->attach(Role::where('name', 'admin')->value('id'));
    }
}
