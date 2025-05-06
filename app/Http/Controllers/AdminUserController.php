<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 
use Illuminate\Validation\Rule; 
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('name')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = ['cliente', 'instructor', 'admin'];

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validRoles = ['cliente', 'instructor', 'admin'];

        try {
            // 1. Validar los datos recibidos del formulario
            // No validamos email ni username porque son readonly en el formulario
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'role' => ['required', Rule::in($validRoles)],
  
            ]);

            $user->update($validatedData);
            return redirect()->route('admin.users.index')
                             ->with('success', '¡Usuario actualizado correctamente!');

        } catch (ValidationException $e) {

            Log::warning('Validación fallida al actualizar usuario: ID ' . $user->id, $e->errors());
       
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
       
            Log::error('Error al actualizar usuario: ID ' . $user->id . ' - ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al actualizar el usuario. Inténtalo de nuevo.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'No puedes eliminar tu propia cuenta de administrador.');
        }

        try {

            $userName = $user->name; 
            $user->delete();

      
            return redirect()->route('admin.users.index')
                             ->with('success', '¡Usuario "' . $userName . '" eliminado correctamente!');

        } catch (QueryException $e) {
         
             Log::error('Error de BBDD al eliminar usuario: ID ' . $user->id . ' - ' . $e->getMessage());
             return redirect()->route('admin.users.index')
                              ->with('error', 'No se pudo eliminar al usuario. Puede tener clases o inscripciones asociadas.');
        } catch (\Exception $e) {
            Log::error('Error inesperado al eliminar usuario: ID ' . $user->id . ' - ' . $e->getMessage());
            return redirect()->route('admin.users.index')
                             ->with('error', 'Error inesperado al eliminar el usuario.');
        }
    }
}
