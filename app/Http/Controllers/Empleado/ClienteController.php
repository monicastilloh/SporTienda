<?php
namespace App\Http\Controllers\Empleado;

use App\Http\Controllers\Controller;
use App\Models\User;

class ClienteController extends Controller {
    public function index() {
        $clientes = User::where('role', 'cliente')->latest()->paginate(20);
        return view('empleado.clientes.index', compact('clientes'));
    }
}