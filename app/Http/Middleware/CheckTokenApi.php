<?php

namespace App\Http\Middleware;

use App\Models\User;

use Closure;

class CheckTokenApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $data = User::where([
                ['id', '=', $request->header('id_user')],
                ['login_token', '=', $request->header('token')]
            ])->first();
        if(!$data){
            return response()->json(['status' => 'failed', 'reason' => 'Invalid token']);
        }
        return $next($request);
    }
}
