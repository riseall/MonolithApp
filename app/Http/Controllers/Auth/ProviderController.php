<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class ProviderController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            // dd($googleUser);
            $user = User::where('google_id', $googleUser->getId())->first();

            if (!$user) {
                $new_user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'role' => $request->role = 'mahasiswa'
                ]);

                Auth::login($new_user);

                if ($new_user->role == 'mahasiswa') {
                    return redirect()->route('user.mahasiswa');
                }

                return redirect()->intended('dashboard');
            } else {
                Auth::login($user);

                return redirect()->intended('dashboard');
            }
        } catch (\Throwable $th) {
            dd('Something went wrong!' . $th->getMessage());
        }
    }
}
