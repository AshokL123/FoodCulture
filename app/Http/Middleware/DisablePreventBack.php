<?php
namespace App\Http\Middleware;
use Closure;

class DisablePreventBack
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (! $request->session()->exists('admin_id')) {
            $request->session()->flash('info', 'Your session was expired!');
            return redirect('/admin');
        }
        
        return $response = $next($request);
    }
}