<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeUserAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:make-admin {email : Email del usuario a hacer admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convierte a un usuario en administrador';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        // Buscar el usuario por email
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("No se encontró un usuario con el email: {$email}");
            return 1;
        }
        
        // Verificar si ya es admin
        if ($user->is_admin) {
            $this->warn("El usuario {$user->name} ya es administrador.");
            return 0;
        }
        
        // Hacer admin al usuario
        $user->update(['is_admin' => true]);
        
        $this->info("¡Usuario {$user->name} ({$user->email}) ahora es administrador!");
        
        // Mostrar información del usuario
        $this->table(
            ['ID', 'Nombre', 'Email', 'Admin', 'Registrado'],
            [[
                $user->id,
                $user->name,
                $user->email,
                'Sí',
                $user->created_at->format('d/m/Y H:i')
            ]]
        );
        
        return 0;
    }
}
