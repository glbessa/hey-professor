<?php

namespace App\Http\Controllers\Auth\Github;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class CallbackController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $github_user = Socialite::driver('github')->user();

        $user = User::query()
            ->updateOrCreate(
                [
                    'nickname' => $github_user->getNickname(),
                    'email'    => $github_user->getEmail(),
                ],
                [
                    'name'              => $github_user->getName(),
                    'password'          => Str::random(16),
                    'email_verified_at' => now(),
                ]
            );

        Auth::login($user);

        return to_route('dashboard');
    }
}
