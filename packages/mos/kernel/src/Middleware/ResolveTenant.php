<?php
namespace Mos\Kernel\Middleware;

use Closure;
use Mos\Models\Tenant; // create a Tenant model under app later or within package
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ResolveTenant
{
    public function handle($request, Closure $next)
    {
        $host = $request->getHost();
        // try domain lookup
        $tenant = \DB::table('tenants')->where('domain', $host)->first();

        // fallback to header
        if(!$tenant && $request->header('X-Tenant-ID')){
            $tenant = \DB::table('tenants')->where('id', $request->header('X-Tenant-ID'))->first();
        }

        if($tenant){
            app()->instance('mos.tenant', $tenant);
            // schema-per-tenant: set search_path
            DB::statement("SET search_path TO tenant_{$tenant->id}, public");
        } else {
            app()->instance('mos.tenant', null);
        }

        return $next($request);
    }
}