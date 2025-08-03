<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class TenantDatabaseServices
{
    public function createDB($tenant)
    {
        DB::statement("CREATE DATABASE " . $tenant->database);
    }

    public function connectToDB($tenant)
    {
        Config::set('database.connections.tenant.database', $tenant->database);
        DB::purge('tenant');
        DB::reconnect('tenant');
        Config::set('database.default', 'tenant');
    }
}