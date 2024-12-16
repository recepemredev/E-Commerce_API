<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;
class RequestLimitMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requestIp = $request->ip();
        
        if(Cache::has('blocked_ip:$requestIp')){
            return response()->json(['message'=>'IP temporarily blocked. Try again later'],403);
        }
        if (!Cache::has("ip_attempts:$requestIp")) {
            Cache::put("ip_attempts:$requestIp", 1, now()->addMinutes(10)); // First request and ip cache save minute
            $attempts = 1; 
        }else{
            $attempts = Cache::increment("ip_attempts:$requestIp");    
        }
        // Attempts limit
        if ($attempts >= 3) {
            Cache::put('blocked_ip:$requestIp', true, now()->addMinutes(2)); // Ip block minute
            Cache::forget('ip_attempts:$requestIp');   
            Cache::put("ip_attempts:$requestIp", 0);   
        }
        return $next($request);
    }
}
