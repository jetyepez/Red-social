<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function ban(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'No puedes banearte a ti mismo.');
        }

        $user->update([
            'is_banned' => true,
            'banned_at' => now(),
            'banned_to' => now()->addDays(7)
        ]);
        return redirect()->back()->with('success', 'Usuario baneado exitosamente.');
    }

    public function unban(User $user)
    {
        $user->update(['is_banned' => false]);
        return redirect()->back()->with('success', 'Usuario desbaneado exitosamente.');
    }

    public function unlock(User $user)
    {
        $user->update(['is_locked' => false]);
        return redirect()->back()->with('success', 'Usuario desbloqueado exitosamente.');
    }

    public function changeRole(User $user, $role)
    {
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'No puedes cambiar tu propio rol.');
        }

        if (!in_array($role, ['admin', 'user'])) {
            return redirect()->back()->with('error', 'Rol inválido.');
        }

        $user->update(['role' => $role]);
        
        // Si el usuario está conectado, forzar cierre de sesión
        if ($user->id === Auth::id()) {
            Auth::logout();
            return redirect()->route('login')->with('success', 'Tu rol ha sido actualizado. Por favor inicia sesión nuevamente.');
        }
        
        return redirect()->back()->with('success', 'Rol de usuario actualizado exitosamente. El usuario debe volver a iniciar sesión.');
    }
} 