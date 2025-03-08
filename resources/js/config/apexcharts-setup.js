// File da importare automaticamente nel tuo app.js
import VueApexCharts from 'vue3-apexcharts';

export default {
    install(app) {
        app.use(VueApexCharts);
        console.log('PacchettoVueJs: ApexCharts configurato con successo!');
    }
};