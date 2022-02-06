<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
class ClientMiddleware
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
    //  dd($request);
        // if ($request->role == "client") {
        //     Route::get('/courses', function (Request $request) {
        //         $request->session()->put('state', $state = Str::random(40));

        //         $query = http_build_query([
        //             'client_id' => $request->client_id,
        //             'redirect_uri' => config('app.client_url'),
        //             'response_type' => 'code',
        //             'scope' => '',
        //             'state' => $state,
        //         ]);

        //         return redirect('/'.$query);
        //     });
        // }
        return $next($request);
    }
  
}