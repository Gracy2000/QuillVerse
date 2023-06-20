<?php

namespace App\Http\Middleware;

use App\Models\Blog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateAuthor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!is_object($request->blog)) {
            $blog = Blog::onlyTrashed()->find($request->blog); // Here $request->blog is not object of blog, it is int id because route model binding is not done because it is trashed so blog will be not found
        } else {
            $blog = $request->blog;
        }

        if(!auth()->user()->isOwner($blog)) {
            return abort(401);
        }
        return $next($request);
    }
}
