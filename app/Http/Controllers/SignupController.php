<?php

namespace App\Http\Controllers;

use App\Models\GymClass; // Modelo de Clase
use App\Models\Signup;   // Modelo de Inscripción (Asegúrate que exista y tenga $fillable)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Para obtener el usuario autenticado
use Illuminate\Support\Facades\Log;   // Para registrar errores
use Illuminate\Database\QueryException; // Para errores de BBDD (ej. unique constraint)
use Exception; // Para capturar excepciones generales

class SignupController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * Guarda una nueva inscripción (apunta a un usuario a una clase).
     *
     * @param Request $request
     * @param GymClass $gymClass La clase a la que se quiere apuntar (inyectada por Route Model Binding)
     */
    public function store(Request $request, GymClass $gymClass)
    {
        $user = Auth::user();

        // --- Comprobaciones ---
        $alreadySignedUp = Signup::where('id_user', $user->id)
                                ->where('id_class', $gymClass->id)
                                ->exists();

        if ($alreadySignedUp) {
            // --- Redirección corregida ---
            return redirect()->route('schedule.today')->with('error', 'Ya estás apuntado a esta clase.');
        }

        $currentSignupsCount = Signup::where('id_class', $gymClass->id)->count();
        if ($currentSignupsCount >= $gymClass->capacity) {
             // --- Redirección corregida ---
            return redirect()->route('schedule.today')->with('error', 'Lo sentimos, la clase está completa.');
        }

        // --- Lógica Límite Categoría (Omitida por ahora) ---
        /*
        $category = $gymClass->category;
        if ($category && $category->max_user_signups_per_period !== null) {
            // ...
            // return redirect()->route('schedule.today')->with('error', 'Límite alcanzado...');
        }
        */

        // --- Crear inscripción ---
        try {
            Signup::create([
                'id_user' => $user->id,
                'id_class' => $gymClass->id,
            ]);

             // --- Redirección corregida ---
            return redirect()->route('schedule.today')->with('success', '¡Te has apuntado a la clase "' . $gymClass->name . '" correctamente!');

        } catch (QueryException $e) {
            Log::error('Error de BBDD al inscribir usuario ' . $user->id . ' a clase ' . $gymClass->id . ': ' . $e->getMessage());
             // --- Redirección corregida ---
            return redirect()->route('schedule.today')->with('error', 'Hubo un error al procesar tu inscripción (Error BBDD).');
        } catch (Exception $e) {
            Log::error('Error inesperado al inscribir usuario ' . $user->id . ' a clase ' . $gymClass->id . ': ' . $e->getMessage());
             // --- Redirección corregida ---
            return redirect()->route('schedule.today')->with('error', 'Hubo un error inesperado al procesar tu inscripción.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Signup $signup)
    {
        // Lo implementaremos después
        return redirect()->route('schedule.today')->with('info', 'Funcionalidad de anular no implementada todavía.');
    }
}
