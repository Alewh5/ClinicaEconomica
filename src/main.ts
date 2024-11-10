import { createApp } from 'vue'
import { createPinia } from 'pinia'
import createPersistedState from 'pinia-plugin-persistedstate'

import App from './App.vue'
import router from './router'
import axios from 'axios'

import './assets/main.css'
import "@hennge/vue3-pagination/dist/vue3-pagination.css";

import DashboardLayout from './components/DashboardLayout.vue'
import EmptyLayout from './components/EmptyLayout.vue'

// AXIOS
window.axios = axios
window.axios.defaults.baseURL = 'http://127.0.0.1:8000/api/v1/'
window.axios.defaults.headers.common['Accept'] = 'application/json'
window.axios.defaults.headers.common['Content-Type'] = 'application/json'
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
window.axios.defaults.headers.withCredentials = true

// PINIA
const pinia = createPinia()
pinia.use(({ store }) => {
    store.router = router
})
pinia.use(createPersistedState)

const app = createApp(App)

// COMPONENTES GLOBALES
app.component('DefaultLayout', DashboardLayout)
app.component('EmptyLayout', EmptyLayout)

// USO DE PINIA Y ROUTER
app.use(pinia)
app.use(router)

// MONTAJE DE LA APLICACIÓN
app.mount('#app')