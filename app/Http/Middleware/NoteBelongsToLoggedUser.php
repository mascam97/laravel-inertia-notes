<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteBelongsToLoggedUser
{
    /**
     * If there is a note in the request and that note does not belongs
     * to the logged user, it return to the index with a warning 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (isset($request->note))
            if (Auth::id() != $request->note->user_id)
                return redirect()->route('notes.index')
                    ->with('warning', 'Action not allowed, you can manage only your notes.');
        return $next($request);
    }
}
