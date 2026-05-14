<?php
namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller {

    public function index() {
        $user   = User::find(Auth::id());
        $orders = $user->orders()->with('items.product')->latest()->paginate(5);
        return view('cliente.profile', compact('user', 'orders'));
    }

    public function update(Request $request) {
        $user = User::find(Auth::id());

        $data = $request->validate([
            'name'    => ['required','string','max:255'],
            'phone'   => ['nullable','string','max:20'],
            'address' => ['nullable','string','max:500'],
        ]);

        // Cambio de contraseña (opcional)
        if ($request->filled('current_password')) {
            $request->validate([
                'current_password'      => ['required'],
                'password'              => ['required','min:8','confirmed'],
                'password_confirmation' => ['required'],
            ]);

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
            }

            $data['password'] = Hash::make($request->password);
        }

        User::where('id', Auth::id())->update($data);

        return back()->with('success', 'Perfil actualizado correctamente.');
    }
}