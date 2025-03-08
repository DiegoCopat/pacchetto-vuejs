<template>
    <div class="chart-container">
      <h2 class="text-xl font-semibold mb-4">{{ title }}</h2>
      <div class="bg-white p-4 rounded-lg shadow">
        <apexchart
          :type="chartType"
          height="350"
          :options="chartOptions"
          :series="series"
        ></apexchart>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'DefaultChart',
    props: {
      title: {
        type: String,
        default: 'Grafico'
      }
    },
    data() {
      return {
        chartType: 'line',
        series: [{
          name: 'Dati',
          data: [30, 40, 35, 50, 49, 60, 70, 91, 125]
        }],
        chartOptions: {
          chart: {
            type: 'line',
            fontFamily: 'Helvetica, Arial, sans-serif',
            toolbar: {
              show: false
            }
          },
          colors: ['#4C51BF'],
          xaxis: {
            categories: ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug', 'Ago', 'Set']
          },
          dataLabels: {
            enabled: false
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