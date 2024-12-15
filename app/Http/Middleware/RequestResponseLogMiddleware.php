<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Logs;
use Symfony\Component\HttpFoundation\Response;

class RequestResponseLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request); // There must be one
        
        $logData = [
            'user_id' => auth()->check() ? auth()->id() : null,
            'request' => json_encode(['url'=>$request->fullUrl(),'dataInfo'=>$request->all()]),
            'request_type' => $request->method(), 
            'request_time' => now(), 
            'response' => $response->getContent(), 
            'response_status' => $response->status(), 
            'ip_address' => $request->ip(), 
        ];
            // Post Check
            if (!$request->isMethod('post')) {
                $queryParams = $request->query();
                if (!empty($queryParams)) {
                    $logData['request'] = json_encode($queryParams); 
                } else {
                    $logData['request'] = json_encode($request->fullUrl()); 
                }
            }
        Logs::create($logData); 
    
        return $response;
    }
}
