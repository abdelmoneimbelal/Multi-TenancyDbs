<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Services\TenantDatabaseServices;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $subdomain = $request->getHost();
        if ($subdomain && $subdomain !== env('APP_URL')) {
            $tenant = Tenant::where('subdomain', $subdomain)->first();
            if($tenant){
                (new TenantDatabaseServices)->connectDB($tenant);
                (new TenantDatabaseServices)->migrateDB($tenant);
            }else {
                abort(404);
            }
        }
        return $next($request);
    }
}
