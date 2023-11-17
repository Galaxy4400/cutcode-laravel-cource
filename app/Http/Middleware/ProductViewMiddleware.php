<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductViewMiddleware
{
	public function handle(Request $request, Closure $next): Response
	{
		session()->put('seen.' . $request->product->id, $request->product->id);

		return $next($request);
	}
}
