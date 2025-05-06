<?php

namespace App\Console\Commands;

use App\Models\Signup; 
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PruneOldClasses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:prune-old-classes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina las inscripciones y/o clases que ya han pasado';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            
            $count = Signup::count();
            Signup::truncate();    
            $this->info("Limpieza completada. Se eliminaron {$count} inscripciones.");
            Log::info("Tarea programada: Se eliminaron {$count} inscripciones de la tabla signups."); 

            return Command::SUCCESS; 

        } catch (\Exception $e) {
            $this->error('Error durante la limpieza de inscripciones: ' . $e->getMessage());
            Log::error('Error en PruneOldClasses: ' . $e->getMessage());
            return Command::FAILURE; 
        }
    }
}
