<?php

namespace App\Http\Controllers;

use App\Models\GymClass;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

class GymClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gymClasses= GymClass::with(['category','instructor'])->orderBy('start_time')->get();

        return view('admin.gym_classes.index', compact('gymClasses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categories::orderBy('name')->get();
        $instructors = User::where('role', 'instructor')->orderBy('name')->get();
        return view('admin.gym_classes.create', compact('categories','instructors'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'id_categories' => 'required|exists:categories,id', 
            'id_instructor' => 'nullable|exists:users,id', 
            'start_time' => 'required|date_format:H:i', 
            'duration_minutes' => 'required|integer|min:15', 
            'capacity' => 'required|integer|min:1', 
        ]);

        try {
            GymClass::create($validatedData); 

            return redirect()->route('admin.gym_classes.index')
                             ->with('success', '¡Clase creada correctamente!');

        } catch (\Exception $e) {
           
            Log::error('Error al crear clase: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al crear la clase. Inténtalo de nuevo.');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(GymClass $gymClass)
    {
        return redirect()->route('admin.gym_classes.edit', $gymClass);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GymClass $gymClass)
    {
        $categories = Categories::orderBy('name')->get();
        $instructors = User::where('role', 'instructor')->orderBy('name')->get();

        return view('admin.gym_classes.edit', compact('gymClass', 'categories', 'instructors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GymClass $gymClass)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'id_categories' => 'required|exists:categories,id',
            'id_instructor' => 'nullable|exists:users,id',
            'start_time' => 'required|date_format:H:i',
            'duration_minutes' => 'required|integer|min:15',
            'capacity' => 'required|integer|min:1',
        ]);

        try {
            $gymClass->update($validatedData);

            return redirect()->route('admin.gym_classes.index')
                             ->with('success', '¡Clase actualizada correctamente!');

        } catch (\Exception $e) {
         
            Log::error('Error al actualizar clase: ID ' . $gymClass->id . ' - ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al actualizar la clase. Inténtalo de nuevo.');
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GymClass $gymClass)
    {
        try {
        
            $gymClass->delete();

        
            return redirect()->route('admin.gym_classes.index')
                             ->with('success', '¡Clase eliminada correctamente!');

        } catch (QueryException $e) {
    
             Log::error('Error de BBDD al eliminar clase: ID ' . $gymClass->id . ' - ' . $e->getMessage());
             return redirect()->route('admin.gym_classes.index')
                              ->with('error', 'Error de base de datos al eliminar la clase.');
        } catch (\Exception $e) {
       
            Log::error('Error inesperado al eliminar clase: ID ' . $gymClass->id . ' - ' . $e->getMessage());
            return redirect()->route('admin.gym_classes.index')
                             ->with('error', 'Error inesperado al eliminar la clase.');
        }
    }
}
