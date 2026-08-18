<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DummyAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Simulasi JWT Token Parsing
        // Untuk testing di Postman, Anda bisa mengirimkan Header:
        // X-User-Id: <uuid_kth_atau_investor>
        
        $userId = $request->header('X-User-Id');
        
        if (!$userId) {
            return response()->json([
                'message' => 'Unauthorized. Header X-User-Id tidak ditemukan (Dummy JWT Middleware).'
            ], 401);
        }

        // Inject user_id ke dalam request agar bisa dibaca oleh Controller (seperti yang kita tulis di controller: $request->user_id)
        $request->merge(['user_id' => $userId]);

        return $next($request);
    }
}
