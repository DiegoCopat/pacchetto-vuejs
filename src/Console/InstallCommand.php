<?php

namespace DiegoCopat\PacchettoVueJs\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'pacchetto-vuejs:install {--force : Sovrascrivi i file esistenti}';
    protected $description = 'Installa e configura il pacchetto PacchettoVueJs';

    public function handle()
    {
        $this->info('Installazione PacchettoVueJs in corso...');
        
        // Pubblica gli assets
        $this->call('vendor:publish', [
            '--provider' => 'DiegoCopat\PacchettoVueJs\PacchettoVueJsServiceProvider',
            '--tag' => 'public',
            '--force' => $this->option('force'),
        ]);
        
        // Pubblica i componenti Vue
        $this->call('vendor:publish', [
            '--provider' => 'DiegoCopat\PacchettoVueJs\PacchettoVueJsServiceProvider',
            '--tag' => 'vue-components',
            '--force' => $this->option('force'),
        ]);
        
        // Pubblica lo script di configurazione
        $this->call('vendor:publish', [
            '--provider' => 'DiegoCopat\PacchettoVueJs\PacchettoVueJsServiceProvider',
            '--tag' => 'config',
            '--force' => $this->option('force'),
        ]);
        
        // Verifica se npm è installato in modo compatibile con Windows
        $npmInstalled = false;
        
        if (PHP_OS_FAMILY === 'Windows') {
            $npmInstalled = !empty(trim(shell_exec('where npm 2>nul')));
        } else {
            $npmInstalled = !empty(trim(shell_exec('which npm 2>/dev/null')));
        }
        
        if ($npmInstalled) {
            $this->info('npm trovato. Installazione delle dipendenze possibile.');
            
            // Modifica package.json per aggiungere le dipendenze
            $packageJsonPath = base_path('package.json');
            if (file_exists($packageJsonPath)) {
                $packageJson = json_decode(file_get_contents($packageJsonPath), true);
                
                // Aggiungi le dipendenze se non esistono già
                if (!isset($packageJson['dependencies']['apexcharts'])) {
                    $packageJson['dependencies']['apexcharts'] = '^3.37.0';
                }
                
                if (!isset($packageJson['dependencies']['vue3-apexcharts'])) {
                    $packageJson['dependencies']['vue3-apexcharts'] = '^1.4.1';
                }
                
                file_put_contents($packageJsonPath, json_encode($packageJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                
                $this->info('Le dipendenze sono state aggiunte al package.json.');
                $this->warn('IMPORTANTE: Esegui manualmente "npm install" o "yarn" per installare le dipendenze.');
            }
        } else {
            $this->error('npm non trovato. DEVI installare manualmente le dipendenze:');
            $this->line('npm install apexcharts vue3-apexcharts');
            $this->line('- OPPURE -');
            $this->line('yarn add apexcharts vue3-apexcharts');
        }
        
        $this->info('Installazione completata con successo!');
        $this->newLine();
        $this->warn('⚠️  PASSAGGIO OBBLIGATORIO:');
        $this->line('Installa i pacchetti npm richiesti:');
        $this->line('    npm install apexcharts vue3-apexcharts');
        $this->newLine();
        $this->line('Per utilizzare il pacchetto, aggiungi nel tuo app.js:');
        $this->line("import PacchettoVueJs from './vendor/diegocopat/apexcharts-setup';");
        $this->line("app.use(PacchettoVueJs);");
        $this->newLine();
        $this->line('Quindi ricompila gli asset con:');
        $this->line('    npm run dev');
        $this->line('    - OPPURE -');
        $this->line('    npm run build');
    }
}