import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import piniaPluginPersistedstate  from 'pinia-plugin-persistedstate';
import router from './src/router';
import App from './src/App.vue';
import ToastPlugin from 'vue-toast-notification';
// Import one of the available themes
//import 'vue-toast-notification/dist/theme-default.css';
import 'vue-toast-notification/dist/theme-bootstrap.css';
import VueApexCharts from 'vue3-apexcharts';

const app = createApp(App);
const pinia = createPinia();

app.use(router);
app.use(pinia);
pinia.use(piniaPluginPersistedstate);
app.use(VueApexCharts);
app.use(ToastPlugin);
app.mount('#app');
