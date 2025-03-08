# Pacchetto VueJS

Un pacchetto PHP per generare configurazioni di grafici per Vue.js utilizzando ApexCharts. Questo pacchetto semplifica l'integrazione tra backend PHP e frontend Vue.js, permettendo di creare grafici moderni, interattivi e visivamente accattivanti.

## Caratteristiche

- Generazione di configurazioni per ApexCharts
- Supporto per vari tipi di grafici (linea, barre, torta, area, radar)
- Personalizzazione completa di colori, stili e opzioni
- Generazione di componenti Vue.js completi
- Supporto per grafici statici e dinamici
- Interfaccia fluida con method chaining

## Requisiti

- PHP 7.4 o superiore
- Composer
- Vue.js 3.x (per il frontend)
- ApexCharts.js e vue3-apexcharts (per il frontend)

## Installazione

```bash
composer require diegocopat/pacchetto-vuejs
```

## Utilizzo Base

### Generazione di una configurazione per grafici

```php
<?php
require 'vendor/autoload.php';

use DiegoCopat\PacchettoVueJs\ChartGenerator;

// Crea un generatore di grafici con dati e etichette
$generator = new ChartGenerator(
    [30, 40, 50, 60, 70],                      // Dati
    ['Gen', 'Feb', 'Mar', 'Apr', 'Mag']        // Etichette
);

// Personalizza il grafico
$generator->setTitle('Vendite Mensili')
    ->setType('line')
    ->setColors(['#4C51BF', '#9F7AEA']);

// Genera la configurazione
$chartConfig = $generator->generateChartConfig();

// Invia al frontend come JSON
header('Content-Type: application/json');
echo json_encode(['chartConfig' => $chartConfig]);
```

### Generazione di un componente Vue.js completo

```php
<?php
require 'vendor/autoload.php';

use DiegoCopat\PacchettoVueJs\ChartGenerator;
use DiegoCopat\PacchettoVueJs\VueChartComponent;

// Crea un generatore di grafici
$generator = new ChartGenerator(
    [30, 40, 50, 60, 70],
    ['Gen', 'Feb', 'Mar', 'Apr', 'Mag']
);

// Personalizza
$generator->setTitle('Vendite Mensili')
    ->setType('area');

// Crea un componente Vue
$componentGenerator = new VueChartComponent($generator, 'VenditeMensiliChart');
$vueCode = $componentGenerator->generateVueComponent();

// Ora puoi salvare il codice Vue in un file
file_put_contents('VenditeMensiliChart.vue', $vueCode);
```

## Configurazione in Vue.js

### Installazione delle dipendenze frontend

```bash
# Installa Vue.js (se non lo hai già fatto)
npm install vue

# Installa ApexCharts e il wrapper Vue
npm install --save apexcharts vue3-apexcharts
```

### Configurazione in Vue.js (main.js)

```javascript
import { createApp } from 'vue'
import App from './App.vue'
import VueApexCharts from "vue3-apexcharts";

const app = createApp(App);
app.use(VueApexCharts);
app.mount('#app');
```

### Utilizzo del componente generato

```vue
<template>
  <div class="dashboard">
    <h1>Dashboard Aziendale</h1>
    <div class="chart-wrapper">
      <VenditeMensiliChart />
    </div>
  </div>
</template>

<script>
import VenditeMensiliChart from './components/VenditeMensiliChart.vue'

export default {
  name: 'App',
  components: {
    VenditeMensiliChart
  }
}
</script>

<style>
.dashboard {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}
.chart-wrapper {
  margin-top: 30px;
}
</style>
```

## Utilizzo del componente dinamico

Il pacchetto può anche generare componenti Vue dinamici che accettano props:

```php
<?php
// Genera un componente dinamico
$componentGenerator = new VueChartComponent($generator, 'ChartComponent');
$vueCode = $componentGenerator->generateDynamicVueComponent();
file_put_contents('ChartComponent.vue', $vueCode);
```

Ecco come utilizzare il componente dinamico nel tuo frontend Vue:

```vue
<template>
  <div class="dashboard">
    <h1>Dashboard Aziendale</h1>
    
    <div class="chart-section">
      <h2>Vendite Mensili</h2>
      <ChartComponent 
        :chartData="venditeMensili.data" 
        :chartLabels="venditeMensili.labels"
        chartTitle="Vendite Mensili 2025"
        chartType="line"
        :chartColors="['#4C51BF']"
      />
    </div>
    
    <div class="chart-section">
      <h2>Profitti per Categoria</h2>
      <ChartComponent 
        :chartData="profittiCategoria.data" 
        :chartLabels="profittiCategoria.labels"
        chartTitle="Profitti per Categoria"
        chartType="bar"
        :chartColors="['#9F7AEA', '#667EEA']"
      />
    </div>
  </div>
</template>

<script>
// Importa il componente del grafico
import ChartComponent from './components/ChartComponent.vue'

export default {
  name: 'App',
  components: {
    ChartComponent
  },
  data() {
    return {
      venditeMensili: {
        data: [30, 40, 35, 50, 49, 60, 70, 91, 125, 110, 100, 120],
        labels: ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug', 'Ago', 'Set', 'Ott', 'Nov', 'Dic']
      },
      profittiCategoria: {
        data: [65, 40, 35, 78, 52],
        labels: ['Elettronica', 'Abbigliamento', 'Alimentari', 'Arredamento', 'Altro']
      }
    }
  }
}
</script>

<style>
.dashboard {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  font-family: Helvetica, Arial, sans-serif;
}

.chart-section {
  margin-bottom: 40px;
}

h1 {
  color: #2d3748;
  margin-bottom: 30px;
}

h2 {
  color: #4a5568;
  margin-bottom: 15px;
}
</style>
```

## Integrazione con Laravel

### Installazione in Laravel

```bash
composer require diegocopat/pacchetto-vuejs
```

### Creazione di un Controller

```php
<?php
// app/Http/Controllers/ChartController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DiegoCopat\PacchettoVueJs\ChartGenerator;

class ChartController extends Controller
{
    public function getChartData()
    {
        // Dati di esempio - in un'applicazione reale proverrebbero dal database
        $venditeMensili = [30, 40, 35, 50, 49, 60, 70, 91, 125, 110, 100, 120];
        $mesi = ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug', 'Ago', 'Set', 'Ott', 'Nov', 'Dic'];
        
        // Usa il generatore dal tuo pacchetto
        $generator = new ChartGenerator($venditeMensili, $mesi);
        $generator->setTitle('Vendite Mensili 2025')
                 ->setType('line')
                 ->setColors(['#4C51BF']);
        
        return response()->json($generator->generateChartConfig());
    }
    
    public function generaComponente()
    {
        // ...codice per generare un componente Vue
    }
}
```

### Rotta API

```php
// routes/api.php
Route::get('/chart-data', [ChartController::class, 'getChartData']);
```

### Utilizzo nel Frontend Vue

```javascript
// Nel componente Vue
export default {
  data() {
    return {
      chartData: null
    }
  },
  mounted() {
    fetch('/api/chart-data')
      .then(response => response.json())
      .then(data => {
        this.chartData = data;
      });
  }
}
```

## Opzioni di personalizzazione

### Tipi di grafico supportati

- `line` - Grafico a linee
- `bar` - Grafico a barre
- `pie` - Grafico a torta
- `donut` - Grafico a ciambella
- `area` - Grafico ad area
- `radar` - Grafico radar

### Stili personalizzati

È possibile personalizzare diversi aspetti del grafico:

```php
$generator->setTitle('Titolo del grafico')
          ->setType('bar')
          ->setColors(['#FF5733', '#33FF57', '#3357FF'])
          // Ulteriori personalizzazioni specifiche
          ->setCustomOption('chart.dropShadow.enabled', false)
          ->setCustomOption('stroke.curve', 'straight');
```

## Metodi disponibili in ChartGenerator

| Metodo | Descrizione |
|--------|-------------|
| `__construct(array $data, array $labels)` | Crea un nuovo generatore con i dati e le etichette |
| `setData(array $data)` | Imposta i dati del grafico |
| `setLabels(array $labels)` | Imposta le etichette sull'asse X |
| `setTitle(string $title)` | Imposta il titolo del grafico |
| `setType(string $type)` | Imposta il tipo di grafico |
| `setColors(array $colors)` | Imposta i colori utilizzati |
| `generateChartConfig()` | Genera l'array di configurazione |
| `renderJsonConfig()` | Genera la configurazione in formato JSON |

## Metodi disponibili in VueChartComponent

| Metodo | Descrizione |
|--------|-------------|
| `__construct(ChartGenerator $generator, string $componentName)` | Crea un nuovo generatore di componenti Vue |
| `generateVueComponent()` | Genera un componente Vue con configurazione statica |
| `generateDynamicVueComponent()` | Genera un componente Vue che accetta props |

## Contribuire

Le contribuzioni sono benvenute! Per favore invia una pull request o apri un issue su GitHub.

## Licenza

MIT