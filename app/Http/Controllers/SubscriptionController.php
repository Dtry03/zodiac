<?php

namespace App\Http\Controllers;

use App\Models\Tenant; // O tu modelo Gym si lo llamaste así
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Para verificar el usuario

class SubscriptionController extends Controller
{
    /**
     * Show the pre-checkout page for a tenant to start their subscription.
     * Muestra la página previa al checkout para que un inquilino inicie su suscripción.
     *
     * @param  \App\Models\Tenant  $tenant (Inyectado por Route Model Binding)
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showCheckout(Tenant $tenant)
    {
        $user = Auth::user();

        return view('subscription.checkout', compact('tenant'));
    }

    /**
     * Redirect the tenant to Stripe's checkout page to process the subscription.
     * (Lo implementaremos en el siguiente paso)
     */
    // public function processCheckout(Request $request, Tenant $tenant)
    // {
    //     // Lógica para generar la sesión de Stripe Checkout y redirigir
    // }

    /**
     * Handle successful subscription (called by Stripe redirect or webhook).
     * (Lo implementaremos después)
     */
    // public function success(Request $request, Tenant $tenant)
    // {
    //     // Lógica después de un pago exitoso
    // }

    /**
     * Handle cancelled subscription attempt (called by Stripe redirect).
     * (Lo implementaremos después)
     */
    // public function cancelled(Request $request, Tenant $tenant)
    // {
    //     // Lógica si el usuario cancela en Stripe
    // }
}
