<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Profile;

class ProfileRepository
{
    public function fetchAll()
    {
        return Profile::all();
    }
}