<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ListUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:list {--admin : Solo usuarios admin} {--count : Solo mostrar conteo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lista todos los usuarios registrados en el sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $query = User::query();

        // Filtro para solo admins si se especifica
        if ($this->option('admin')) {
            $query->where('is_admin', true);
            $this->info('Mostrando solo usuarios administradores:');
        }

        // Si solo queremos el conteo
        if ($this->option('count')) {
            $count = $query->count();
            $this->info("Total de usuarios: {$count}");
            return;
        }

        // Obtener usuarios
        $users = $query->orderBy('created_at', 'desc')->get();

        if ($users->isEmpty()) {
            $this->warn('No se encontraron usuarios.');
            return;
        }

        // Mostrar información en tabla
        $headers = ['ID', 'Nombre', 'Email', 'Admin', 'Registrado'];
        $rows = [];

        foreach ($users as $user) {
            $rows[] = [
                $user->id,
                $user->name,
                $user->email,
                isset($user->is_admin) && $user->is_admin ? 'Sí' : 'No',
                $user->created_at->format('d/m/Y H:i'),
            ];
        }

        $this->table($headers, $rows);

        // Mostrar estadísticas
        $this->newLine();
        $this->info('Estadísticas:');
        $this->line("Total de usuarios: {$users->count()}");
        
        if (isset($users->first()->is_admin)) {
            $this->line("Usuarios admin: " . $users->where('is_admin', true)->count());
            $this->line("Usuarios normales: " . $users->where('is_admin', false)->count());
        }
        
        $this->line("Usuarios registrados hoy: " . $users->where('created_at', '>=', now()->startOfDay())->count());
    }
}
