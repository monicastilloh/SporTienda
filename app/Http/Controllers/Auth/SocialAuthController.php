<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller {
    public function redirect(string $provider) {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider) {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Error al autenticar con ' . $provider);
        }

        $user = User::updateOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name'        => $socialUser->getName(),
                'provider'    => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar'      => $socialUser->getAvatar(),
                'role'        => 'cliente',
                'password'    => null,
            ]
        );

        Auth::login($user, true);

        return match($user->role) {
            'admin'    => redirect()->route('admin.dashboard'),
            'empleado' => redirect()->route('empleado.productos'),
            default    => redirect()->route('shop'),
        };
    }
}