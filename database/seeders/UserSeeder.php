<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@footballnews.test'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'editor@footballnews.test'],
            [
                'name' => 'Budi Editor',
                'password' => Hash::make('password'),
                'role' => 'editor',
            ]
        );

        User::updateOrCreate(
            ['email' => 'author1@footballnews.test'],
            [
                'name' => 'Rina Author',
                'password' => Hash::make('password'),
                'role' => 'author',
            ]
        );

        User::updateOrCreate(
            ['email' => 'author2@footballnews.test'],
            [
                'name' => 'Andi Author',
                'password' => Hash::make('password'),
                'role' => 'author',
            ]
        );

        User::updateOrCreate(
            ['email' => 'author3@footballnews.test'],
            [
                'name' => 'Dimas Author',
                'password' => Hash::make('password'),
                'role' => 'author',
            ]
        );
    }
}