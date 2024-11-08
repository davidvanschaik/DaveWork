<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public static function run(): void
    {
        User::factory()
            ->has(Profile::factory()->has(Post::factory()->count(3)))
            ->count(10)
            ->create();
    }
}
