<?php

namespace DiegoCopat\PacchettoVueJs;

class VueChartComponent
{
    private $chartGenerator;
    private $componentName;
    
    public function __construct(ChartGenerator $chartGenerator, string $componentName = 'ChartComponent')
    {
        $this->chartGenerator = $chartGenerator;
        $this->componentName = $componentName;
    }
    
    public function generateVueComponent(): string
    {
        $config = $this->chartGenerator->generateChartConfig();
        $series = json_encode($config['series']);
        $options = json_encode($config['chartOptions']);
        
        return <<<EOT
<template>
  <div class="chart-container">
    <apexchart
      type="{$config['chartOptions']['chart']['type']}"
      height="350"
      :options="chartOptions"
      :series="series"
    ></apexchart>
  </div>
</template>

<script>
export default {
  name: '{$this->componentName}',
  data() {
    return {
      series: {$series},
      chartOptions: {$options}
    }
  }
}
</script>

<style scoped>
.chart-container {
  background-color: white;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}
</style>
EOT;
    }
    
    public function generateDynamicVueComponent(): string
    {
        return <<<EOT
<template>
  <div class="chart-container">
    <apexchart
      :type="chartType"
      height="350"
      :options="chartOptions"
      :series="series"
    ></apexchart>
  </div>
</template>

<script>
export default {
  name: '{$this->componentName}',
  props: {
    chartData: {
      type: Array,
      required: true
    },
    chartLabels: {
      type: Array,
      required: true
    },
    chartTitle: {
      type: String,
      default: 'Grafico'
    },
    chartType: {
      type: String,
      default: 'line'
    },
    chartColors: {
      type: Array,
      default: () => ['#5C6AC4']
    }
  },
  computed: {
    series() {
      return [{
        name: "Dati",
        data: this.chartData
      }]
    },
    chartOptions() {
      return {
        chart: {
          type: this.chartType,
          fontFamily: 'Helvetica, Arial, sans-serif',
          toolbar: {
            show: false
          },
          dropShadow: {
            enabled: true,
            color: '#000',
            top: 18,
            left: 7,
            blur: 10,
            opacity: 0.2
          }
        },
        colors: this.chartColors,
        stroke: {
          curve: 'smooth',
          width: 3
        },
        grid: {
          borderColor: '#e0e0e0',
          row: {
            colors: ['#f3f3f3', 'transparent'],
            opacity: 0.5
          }
        },
        markers: {
          size: 6,
          colors: this.chartColors,
          strokeColors: '#fff',
          strokeWidth: 2
        },
        xaxis: {
          categories: this.chartLabels
        },
        dataLabels: {
          enabled: false
        },
        title: {
          text: this.chartTitle,
          align: 'center',
          style: {
            fontSize: '18px',
            fontWeight: 'bold'
          }
        },
        tooltip: {
          theme: 'dark',
          x: {
            show: true,
          }
        },
        theme: {
          mode: 'light'
        }
      }
    }
  }
}
</script>

<style scoped>
.chart-container {
  background-color: white;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}
</style>
EOT;
    }
}