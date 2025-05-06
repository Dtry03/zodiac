<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Log; 

class DeactivateInactiveUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deactivate-inactive-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Desactiva usuarios que no han iniciado sesión en un periodo determinado';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $inactivePeriod = Carbon::now()->subMonths(6);
        $this->info("Fecha límite para último login o registro: " . $inactivePeriod->format('Y-m-d H:i:s'));

        try {
            // Buscar usuarios candidatos a eliminar:
            $inactiveUsersQuery = User::where('role', '!=', 'admin') 
                                ->whereNotNull('last_login_at') 
                                ->where('last_login_at', '<', $inactivePeriod);

            // Contar cuántos se van a eliminar (antes de hacerlo)
            $count = $inactiveUsersQuery->count();

            if ($count > 0) {
                $this->info("Se encontraron {$count} usuarios inactivos para eliminar.");

                 if ($this->confirm('¿Estás ABSOLUTAMENTE SEGURO de que quieres eliminar permanentemente a estos ' . $count . ' usuarios? ESTA ACCIÓN NO SE PUEDE DESHACER.', false)) {

                 
                    $inactiveUsers = $inactiveUsersQuery->get();
                    $deletedCount = 0;

                    foreach ($inactiveUsers as $user) {
                        $userInfo = "Usuario ID {$user->id} - {$user->email}";
                        try {
                            $user->delete(); 
                            $this->line("{$userInfo} - ELIMINADO.");
                            Log::info("Usuario inactivo eliminado: {$userInfo}");
                            $deletedCount++;
                        } catch (\Exception $e) {
                            $this->error("Error al eliminar {$userInfo}: " . $e->getMessage());
                            Log::error("Error al eliminar usuario inactivo {$user->id}: " . $e->getMessage());
                        }
                    }
                    $this->info("Proceso de eliminación completado. Se eliminaron {$deletedCount} usuarios.");

                 } else {
                     $this->info('Eliminación cancelada por el usuario.');
                     return Command::SUCCESS; 
                 }

            } else {
                $this->info('No se encontraron usuarios inactivos para eliminar.');
            }

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Error durante la búsqueda/eliminación de usuarios inactivos: ' . $e->getMessage());
            Log::error('Error en DeactivateInactiveUsers: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
