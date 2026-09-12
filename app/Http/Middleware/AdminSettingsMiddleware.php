<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AdminSettings;

class AdminSettingsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $model = AdminSettings::first();
            if ($model) {
                foreach ($model->attributesToArray() as $key => $value) {
                    config(['settings.' . $key => $value]);
                }
            }
        } catch (\Exception $e) {}
        
        return $next($request);
    }
}
