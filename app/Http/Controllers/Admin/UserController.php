<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    public function index() {
        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create() {
        return view('admin.users.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name'     => ['required','string','max:255'],
            'email'    => ['required','email','unique:users'],
            'password' => ['required','min:8'],
            'phone'    => ['nullable','string','max:20'],
            'role'     => ['required','in:admin,empleado,cliente'],
            'active'   => ['boolean'],
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['active']   = $request->boolean('active', true);
        User::create($data);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado.');
    }

    public function edit(User $usuario) {
        return view('admin.users.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario) {
        $data = $request->validate([
            'name'   => ['required','string','max:255'],
            'email'  => ['required','email','unique:users,email,'.$usuario->id],
            'phone'  => ['nullable','string','max:20'],
            'role'   => ['required','in:admin,empleado,cliente'],
            'active' => ['boolean'],
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => ['min:8']]);
            $data['password'] = Hash::make($request->password);
        }

        $data['active'] = $request->boolean('active');
        $usuario->update($data);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado.');
    }

    public function destroy(User $usuario) {
        $usuario->delete();
        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado.');
    }
}