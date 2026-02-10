<?php

namespace App\Http\Middleware;

use App\Enums\DealerStatus;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDealer
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isDealer()) {
            abort(403, 'Access restricted to dealers.');
        }

        $dealer = $user->dealer;

        if (! $dealer || ! $dealer->isApproved()) {
            return redirect()->route('dealer.pending');
        }

        return $next($request);
    }
}
