<?php
namespace App\Http\Controllers;
use App\Models\Tenant; 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules; 
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered; 

class TenantRegistrationController extends Controller
{

    public function create()
    {
        return view('auth.tenant-register');
    }

        public function store(Request $request)
    {
       
        try {
            $validatedData = $request->validate([
                'gym_name' => ['required', 'string', 'max:255', 'unique:tenants,name'], // Nombre del gimnasio único
                'admin_name' => ['required', 'string', 'max:255'],
                'admin_last_name' => ['nullable', 'string', 'max:255'],
                'admin_email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'], // Email del admin único globalmente
                'admin_password' => ['required', 'confirmed', Rules\Password::defaults()], // Contraseña confirmada y con reglas por defecto de Laravel
            ], [
               
                'gym_name.required' => 'El nombre del gimnasio es obligatorio.',
                'gym_name.unique' => 'Este nombre de gimnasio ya está registrado.',
                'admin_name.required' => 'Tu nombre es obligatorio.',
                'admin_email.required' => 'Tu email es obligatorio.',
                'admin_email.email' => 'El formato del email no es válido.',
                'admin_email.unique' => 'Este email ya está registrado.',
                'admin_password.required' => 'La contraseña es obligatoria.',
                'admin_password.confirmed' => 'La confirmación de contraseña no coincide.',
            ]);
        } catch (ValidationException $e) {
            Log::warning('Validación fallida en registro de tenant: ', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        }


        DB::beginTransaction();

        try {
  
            $tenant = Tenant::create([
                'name' => $validatedData['gym_name'],

            ]);

            
            $adminUser = User::create([
                'name' => $validatedData['admin_name'],
                'last_name' => $validatedData['admin_last_name'],
                'email' => $validatedData['admin_email'],
                'password' => Hash::make($validatedData['admin_password']),
                'role' => 'admin', 
                'tenant_id' => $tenant->id, 
                'active' => true, 
              
            ]);

            DB::commit();

         
            Log::info("Tenant ID {$tenant->id} y Admin User ID {$adminUser->id} creados. Redirigiendo a checkout.");
            return redirect()->route('subscription.checkout.show', ['tenant' => $tenant->id])
                             ->with('status', '¡Gimnasio y cuenta de administrador creados! Ahora, configura tu suscripción.');

        } catch (\Exception $e) {
         
            DB::rollBack();
            Log::error('Error al crear tenant o usuario admin: ' . $e->getMessage(), ['exception' => $e]);
            return back()->withInput()->with('error', 'Error al registrar el gimnasio. Por favor, inténtalo de nuevo. Detalles: ' . $e->getMessage());
        }
    }

}
