<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class ProjectResetCommand extends Command
{
    protected $signature = 'project:reset';

    protected $description = 'Resetea la BD, corre seeders y genera permisos de Shield.';

    public function handle()
    {
        // 1. Bloqueo de seguridad para Producción
        if (App::isProduction()) {

            $this->error('¡ALERTA! Este comando NO se puede ejecutar en un entorno de producción.');

            return Command::FAILURE;
        }

        $this->info('Iniciando reseteo del proyecto...');

        // 2. Ejecución de comandos
        $this->call('migrate:fresh');
        $this->call('db:seed', ['--class' => 'RolesSeeder']);
        $this->call('db:seed', ['--class' => 'AdminSeeder']);
        $this->call('db:seed', ['--class' => 'StaticPageSeeder']);
        $this->call('db:seed', ['--class' => 'ServiceSeeder']);

        $this->info('Generando permisos Shield para Dashboard...');
        $this->call('shield:generate', ['--all' => true, '--panel' => 'dashboard']);

        $this->info('¡Proyecto reseteado correctamente!');

        return Command::SUCCESS;
    }
}
