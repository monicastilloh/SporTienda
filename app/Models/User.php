<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable {
    use Notifiable;

    protected $fillable = [
        'name','email','password','phone','address','avatar',
        'provider','provider_id','role','active'
    ];

    protected $hidden = ['password','remember_token'];

    protected function casts(): array {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed'];
    }

    public function isAdmin(): bool    { return $this->role === 'admin'; }
    public function isEmpleado(): bool { return $this->role === 'empleado'; }
    public function isCliente(): bool  { return $this->role === 'cliente'; }

    public function orders() { return $this->hasMany(Order::class); }
    public function cart()   { return $this->hasMany(Cart::class); }
}
