<?php

namespace App\Http\Controllers;

use App\Models\GymClass; 
use Carbon\Carbon; 
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DailyReportController extends Controller
{
    /**
     * Display the signups for all classes on the effective day.
     * Muestra los inscritos para todas las clases del día efectivo.
     */
    public function dailySignups()
    {
        $now = Carbon::now();
        $effectiveDate = ($now->hour >= 21) ? $now->copy()->addDay() : $now;
        $effectiveDayOfWeek = $effectiveDate->dayOfWeekIso; // 

        // Nombres de los días
        $dayNames = [1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo'];
        $effectiveDayName = $dayNames[$effectiveDayOfWeek] ?? 'Día Desconocido';

    
        $todaysClasses = GymClass::with(['signups' => function ($query) {
                                    $query->with('user');
                                }, 'category', 'instructor']) 
                                ->where('day_of_week', $effectiveDayOfWeek)
                                ->orderBy('start_time')
                                ->get();

        return view('admin.reports.daily_signups', [
            'todaysClasses' => $todaysClasses,
            'effectiveDate' => $effectiveDate,
            'effectiveDayName' => $effectiveDayName,
        ]);
    }

    public function downloadDailySignupsPdf()
    {
         // 1. Obtener los mismos datos que en dailySignups()
        $now = Carbon::now();
        $effectiveDate = ($now->hour >= 21) ? $now->copy()->addDay() : $now;
        $effectiveDayOfWeek = $effectiveDate->dayOfWeekIso;
        $dayNames = [1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo'];
        $effectiveDayName = $dayNames[$effectiveDayOfWeek] ?? 'Día Desconocido';

        $todaysClasses = GymClass::with(['signups' => function ($query) {
                                    $query->with('user');
                                }, 'category', 'instructor'])
                                ->where('day_of_week', $effectiveDayOfWeek)
                                ->orderBy('start_time')
                                ->get();

        // 2. Preparar los datos para la vista PDF
        $data = [
            'todaysClasses' => $todaysClasses,
            'effectiveDate' => $effectiveDate,
            'effectiveDayName' => $effectiveDayName,
        ];

        // 3. Cargar la vista Blade específica para el PDF
        // Laravel buscará en resources/views/admin/reports/pdf/daily_signups.blade.php
        $pdf = Pdf::loadView('admin.reports.pdf.daily_signups', $data);

   
        $fileName = 'listas_inscritos_' . $effectiveDate->format('Y-m-d') . '.pdf';

        return $pdf->stream($fileName);
    }

    public function downloadClassSignupsPdf(GymClass $gymClass)
    {
        $gymClass->load(['signups.user', 'category', 'instructor']);

        $data = [
            'gymClass' => $gymClass,
        ];


        // 3. Cargar la vista Blade específica para el PDF
        // Laravel buscará en resources/views/admin/reports/pdf/daily_signups.blade.php
        $pdf = Pdf::loadView('admin.reports.pdf.class_signups', $data);

   
        $fileName = 'lista_' .$gymClass->name . '_' . now()->format('Y-m-d') . '.pdf';

        return $pdf->stream($fileName);
    }


}