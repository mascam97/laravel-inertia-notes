<?php

namespace App\Support\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

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
        // Note: A Policy is a better practice, but this Middleware works great also.
        if (isset($request->note)) {
            if ($request->user()->id != $request->note->user_id) {
                return redirect()->route('notes.index')
                    ->with('warning', 'Action not allowed, you can manage only your notes.');
            }
        }
        return $next($request);
    }
}
