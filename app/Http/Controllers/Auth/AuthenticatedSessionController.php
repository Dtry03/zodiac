<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $userId = Auth::id();

        if ($userId) {
    
            $user = User::find($userId);
            if ($user) {
        
                try {
                    $user->update(['last_login_at' => Carbon::now()]);
                } catch (\Exception $e) {
                   
                    Log::error('Error al actualizar last_login_at para usuario ID ' . $userId . ': ' . $e->getMessage());
                }
            } else {
                 Log::warning('Usuario autenticado con ID ' . $userId . ' no encontrado en la BBDD al intentar actualizar last_login_at.');
            }
        }
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
