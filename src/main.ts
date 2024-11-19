import { createApp } from 'vue'
import { createPinia } from 'pinia'
import createPersistedState from 'pinia-plugin-persistedstate'

import App from './App.vue'
import router from './router'
import axios from 'axios'

import './assets/main.css'
import "@hennge/vue3-pagination/dist/vue3-pagination.css"

import DashboardLayout from './components/DashboardLayout.vue'
import EmptyLayout from './components/EmptyLayout.vue'

// Declaración más específica que resuelve el problema de tipos
declare global {
    interface Window {
        axios: any; // Temporalmente usamos 'any' para evitar el error de tipos
    }
}

// Configuración global de axios
axios.defaults.baseURL = 'http://farmaciaesperanza.top/api/v1/';
axios.defaults.withCredentials = true;
axios.defaults.headers['Accept'] = 'application/json';
axios.defaults.headers['Content-Type'] = 'application/json';
axios.defaults.headers['X-Requested-With'] = 'XMLHttpRequest';

// Asignación a window.axios (si quieres acceder desde la consola o en otros lugares)
window.axios = axios;

// PINIA
const pinia = createPinia()
pinia.use(({ store }) => {
    store.router = router
})
pinia.use(createPersistedState)

const app = createApp(App)

app.component('DefaultLayout', DashboardLayout)
app.component('EmptyLayout', EmptyLayout)

app.use(pinia)
app.use(router)

app.mount('#app')
