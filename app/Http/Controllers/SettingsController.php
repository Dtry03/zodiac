<?php

// Asegúrate que el namespace sea correcto
namespace App\Http\Controllers; // O App\Http\Controllers si no usaste subcarpeta

use App\Http\Controllers\Controller;
// Asegúrate que la ruta a AppearanceSettings sea la correcta donde creaste el archivo
use App\Settings\AppearanceSettings; // O Database\Settings\AppearanceSettings si lo creó ahí make:settings
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Para manejar archivos
use Illuminate\Support\Facades\Log;     // Para logs
use Illuminate\Validation\ValidationException; // Para errores de validación

class SettingsController extends Controller
{
    /**
     * Show the form for editing application settings.
     * Muestra el formulario para editar la configuración de la aplicación.
     */
    public function edit(AppearanceSettings $settings) // Inyectar la clase de configuración
    {
        // La clase $settings ya contiene los valores actuales cargados desde la BBDD
        // gracias a la inyección de dependencias y al paquete spatie.

        // Pasamos el objeto $settings completo a la vista
        return view('admin.settings.edit', compact('settings'));
    }

    /**
     * Update the application settings in storage.
     * Actualiza la configuración de la aplicación.
     */
    public function update(Request $request, AppearanceSettings $settings) // Inyectar la clase de configuración
    {
        try {
            // 1. Validar los datos del formulario
            $validatedData = $request->validate([
                'app_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:1024', // Logo opcional
                'app_color' => ['required', 'string', 'regex:/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/'], // Color requerido
            ]);

            // Variable para almacenar la ruta final del logo
            $finalLogoPath = $settings->app_logo; // Empezar con el valor actual

            // 2. Manejar subida del logo (si se envió uno nuevo)
            if ($request->hasFile('app_logo') && $request->file('app_logo')->isValid()) {
                // Borrar el logo antiguo del disco si existe
                if ($settings->app_logo && Storage::disk('public')->exists($settings->app_logo)) {
                    Storage::disk('public')->delete($settings->app_logo);
                }
                // Guardar el nuevo logo y actualizar la variable de ruta
                $finalLogoPath = $request->file('app_logo')->store('logos', 'public');
            }

             // 3. Asignar explícitamente las propiedades al objeto $settings ANTES de guardar
             $settings->app_logo = $finalLogoPath; // Asigna la ruta nueva o la antigua
             $settings->app_color = $validatedData['app_color']; // Asigna el color validado
 
             // --- DEBUG ANTES DE GUARDAR (Comentado o eliminado) ---
             // dd(
             //     'Objeto $settings justo antes de save():', $settings,
             //     'Valor de $settings->app_logo:', $settings->app_logo,
             //     'Valor de $settings->app_color:', $settings->app_color
             // );
 
             // 4. Guardar TODOS los cambios en la base de datos usando el paquete Spatie
             $settings->save(); // <-- DESCOMENTADO
 
             // 5. Redirigir de vuelta al formulario con mensaje de éxito
             return redirect()->route('admin.settings.edit') // <-- DESCOMENTADO
                              ->with('success', '¡Configuración actualizada correctamente!');
        } catch (ValidationException $e) {
            // Si la validación falla, redirige automáticamente con errores
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Manejo de otros errores (ej. subida de archivo, guardado)
            Log::error('Error al actualizar configuración: ' . $e->getMessage());
            // --- DEBUG: Ver excepción si ocurre aquí ---
            // dd('Excepción durante el update:', $e);
            return back()->withInput()->with('error', 'Error al actualizar la configuración. Inténtalo de nuevo.');
        }
    }
}
