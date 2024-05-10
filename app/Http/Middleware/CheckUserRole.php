<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Account;

class CheckAccountOwner
{
    public function handle(Request $request, Closure $next)
    {
        $accountId = $request->route('id');

        // Check if the account_id is 1 (admin)
        if ($accountId == 1) {
            // Set the user role to 'admin'
            $userRole = 'admin';
        } else {
            // Set the user role to 'user'
            $userRole = 'user';
        }

        // Pass the user role to the request for later use
        $request->merge(['user_role' => $userRole]);

        return $next($request);
    }
}
