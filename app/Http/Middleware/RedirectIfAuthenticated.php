<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        // dd($request);
        if (Auth::guard($guard)->check()) {
            return redirect(RouteServiceProvider::HOME);
        }
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

        //         return redirect('/oauth/token'.$query);
        //     });
        // }
        return $next($request);
    }
}
