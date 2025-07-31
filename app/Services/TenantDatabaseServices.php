<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class TenantDatabaseServices
{
    public function createDB($tenant)
    {
        DB::statement("CREATE DATABASE " . $tenant->database);
    }
}