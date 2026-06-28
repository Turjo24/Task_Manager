<?php

namespace app\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect user to Google
     */
    public function redirect()
    {
        return Socialite::driver('google')
            ->stateless()
            ->redirect();
    }

    /**
     * Google callback
     */
    public function callback()
    {
        try {

            $googleUser = Socialite::driver('google')
                ->stateless()
                ->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {

                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => Str::password(20),
                ]);

            } else {

                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);

            }

            $token = $user->createToken('google-login')->plainTextToken;

            return response()->json([
                'message' => 'Google login successful',
                'token' => $token,
                'user' => $user,
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Google login failed',
                'error' => $e->getMessage(),
            ], 500);

        }
    }
}