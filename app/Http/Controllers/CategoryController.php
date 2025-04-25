<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::orderBy("name")->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // 1. Validar los datos del formulario
         $validatedData = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name', 
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'max_user_signups_per_period' => 'nullable|integer|min:1', 
        ]);

        $iconPath = null; 

 
        if ($request->hasFile('icon') && $request->file('icon')->isValid()) {
           
            $iconPath = $request->file('icon')->store('category_icons', 'public');
        }

        // 3. Crear la categoría en la base de datos
        try {
            Categories::create([
                'name' => $validatedData['name'],
                'icon' => $iconPath, 
                'max_user_signups_per_period' => $validatedData['max_user_signups_per_period'] ?? null, 
            ]);

            // 4. Redirigir a la lista con mensaje de éxito
            return redirect()->route('admin.categories.index')
                             ->with('success', '¡Categoría creada correctamente!'); 

        } catch (\Exception $e) {
   
            Log::error('Error al crear categoría: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al crear la categoría. Inténtalo de nuevo.');
        }
    }

    
    /**
     * Display the specified resource.
     */
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categories $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categories $category)
    {
      
        $validatedData = $request->validate([
           
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories')->ignore($category->id), 
            ],
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'max_user_signups_per_period' => 'nullable|integer|min:1', 
        ]);

        $iconPath = $category->icon; 

       
        if ($request->hasFile('icon') && $request->file('icon')->isValid()) {
         
            if ($category->icon) {
                Storage::disk('public')->delete($category->icon);
            }
            
            $iconPath = $request->file('icon')->store('category_icons', 'public');
        }

   
        try {
            $category->update([
                'name' => $validatedData['name'],
                'icon' => $iconPath, 
                'max_user_signups_per_period' => $validatedData['max_user_signups_per_period'] ?? null,
            ]);

         
            return redirect()->route('admin.categories.index')
                             ->with('success', '¡Categoría actualizada correctamente!');

        } catch (\Exception $e) {
            
            Log::error('Error al actualizar categoría: ' . $e->getMessage());
  
            return back()->withInput()->with('error', 'Error al actualizar la categoría. Inténtalo de nuevo.');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categories $category)
    {
        try {
            // Guardar la ruta del icono antes de borrar la categoría
            $iconPath = $category->icon;

            // Intentar eliminar la categoría de la base de datos
            $category->delete();

            // Si la eliminación fue exitosa y había un icono, borrar el archivo del icono
            if ($iconPath) {
                Storage::disk('public')->delete($iconPath);
            }

            // Redirigir a la lista con mensaje de éxito
            return redirect()->route('admin.categories.index')
                             ->with('success', '¡Categoría eliminada correctamente!');

        } catch (QueryException $e) {
            // Capturar específicamente errores de base de datos (como violación de FK)
            // El código '23000' suele indicar una violación de integridad referencial
            if ($e->getCode() === '23000') {
                Log::warning('Intento de eliminar categoría con clases asociadas: ID ' . $category->id . ' - ' . $e->getMessage());
                return redirect()->route('admin.categories.index')
                                 ->with('error', 'No se puede eliminar la categoría porque tiene clases asociadas.');
            } else {
                // Otro error de base de datos
                Log::error('Error de base de datos al eliminar categoría: ' . $e->getMessage());
                return redirect()->route('admin.categories.index')
                                 ->with('error', 'Error de base de datos al eliminar la categoría.');
            }
        } catch (\Exception $e) {
            // Capturar cualquier otro error inesperado
            Log::error('Error inesperado al eliminar categoría: ' . $e->getMessage());
            return redirect()->route('admin.categories.index')
                             ->with('error', 'Error inesperado al eliminar la categoría.');
        }
    }
}
