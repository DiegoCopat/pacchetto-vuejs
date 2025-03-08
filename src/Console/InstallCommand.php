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
        
        // Verifica se npm è installato
        $npmInstalled = shell_exec('which npm') !== null;
        
        if ($npmInstalled) {
            $this->info('Installazione delle dipendenze npm...');
            
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
                
                // Esegui npm install
                $this->info('Esecuzione di npm install...');
                shell_exec('npm install');
            }
        } else {
            $this->warn('npm non trovato. Per favore installa manualmente le dipendenze:');
            $this->line('npm install apexcharts vue3-apexcharts');
        }
        
        $this->info('Installazione completata con successo!');
        $this->line('');
        $this->line('Per utilizzare il pacchetto, aggiungi nel tuo app.js:');
        $this->line("import PacchettoVueJs from './vendor/diegocopat/apexcharts-setup';");
        $this->line("app.use(PacchettoVueJs);");
    }
}