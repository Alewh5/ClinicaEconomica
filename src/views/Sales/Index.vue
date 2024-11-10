<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useAuthStore } from '../../auth.js';
import { confirmation, sendRequest } from '../../function';
import VPagination from "@hennge/vue3-pagination";

const authStore = useAuthStore();

axios.defaults.headers.common['Authorization'] = 'Bearer ' + authStore.authToken;

const sales = ref([]);
const search = ref('');

//PAGINATION
let load = ref(false);
let currentPage = ref();
let totalRecords = ref(0);
let totalPages = ref();
let perPage = ref(5);

const getSales = async (page) => {
    const response = await axios.get(`/sales?page=${page}&per_page=${perPage.value}&search=${search.value}`);
    sales.value = response.data.data;
    currentPage.value = response.data.current_page;
    totalRecords.value = response.data.total;
    load.value = true;
    totalPages = Math.ceil(totalRecords.value / perPage.value);
}

const searchData = () => {
    loadData(1);
};

const loadData = async (newPage) => {
    if (newPage) {
        currentPage.value = newPage;
    }

    await getSales(currentPage.value);
}

onMounted(() => { loadData(1) });
</script>

<template>
    <h3 class="flex items-center text-2xl mb-2 font-semibold text-gray-700">
        Listado de Ventas
        <!-- Loader -->
        <span class="flex-col gap-4 flex items-center justify-center">
            <span v-if="!load"
                class="w-7 h-7 border-2 ml-2 text-blue-400 text-4xl animate-spin border-gray-300 flex items-center justify-center border-t-blue-400 rounded-full">
                <svg viewBox="0 0 24 24" fill="currentColor" height="0.2em" width="0.2em" class="animate-ping">
                    <path
                        d="M12.001 4.8c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624C13.666 10.618 15.027 12 18.001 12c3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C16.337 6.182 14.976 4.8 12.001 4.8zm-6 7.2c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624 1.177 1.194 2.538 2.576 5.512 2.576 3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C10.337 13.382 8.976 12 6.001 12z">
                    </path>
                </svg>
            </span>
        </span>
    </h3>
    <div class="flex sjustify-between items-center flex-row ">
        <div class="flex flex-col sm:flex-row w-full sm:items-center">
            <div class="flex sm:mb-0 mb-1">
                <div class="relative mr-2">
                    <select v-model="perPage" @change="loadData(1)"
                        class="block sm:w-full w-100% px-3 pr-8 py-1 leading-tight text-gray-700 bg-white border
                        border-gray-400 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                    </select>

                    <div class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 pointer-events-none">
                        <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="relative block sm:mt-0 mt-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                    <svg viewBox="0 0 24 24" class="w-4 h-4 text-gray-500 fill-current">
                        <path
                            d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z" />
                    </svg>
                </span>

                <input placeholder="Buscar..." v-model="search" @input="searchData"
                    class="block w-full py-1 sm:py-1 pl-8 pr-0 sm:pr-10 text-sm text-gray-700 placeholder-gray-400 bg-white border border-gray-400 rounded appearance-none focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none">
            </div>
        </div>

        <div class="flex w-26 flex-col sm:flex-row items-center">
            <router-link
                class="inline-flex items-center w-full sm:mb-0 mb-1 px-2 py-1 ml-2 bg-lime-600 transition ease-in-out delay-75 hover:bg-lime-700 text-white text-sm font-medium rounded-md"
                to="/sales/create">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-cart-check-fill mr-2 h-4 w-4"
                    viewBox="0 0 16 16">
                    <path
                        d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m-1.646-7.646-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708" />
                </svg>
                Vender
            </router-link>
        </div>
    </div>

    <div class="flex flex-col mt-6" v-show="load">
        <div class="py-2 overflow-x-auto overflow-y-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow rounded">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th
                                class="px-6 py-2 text-xs font-bold leading-4 tracking-wider text-left text-white uppercase bg-gray-900 border-b border-gray-200">
                                Código
                            </th>
                            <th
                                class="px-6 py-2 text-xs font-bold leading-4 tracking-wider text-left text-white uppercase bg-gray-900 border-b border-gray-200">
                                Detalles
                            </th>
                            <th
                                class="px-6 py-2 text-xs font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200">
                                Gasto
                            </th>
                            <th
                                class="px-6 py-2 text-xs font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200">
                                Total
                            </th>
                            <th
                                class="px-6 py-2 text-xs font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200">
                                Acciones
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white">
                        <tr v-for="(sale, index) in sales" :key="sale.id">
                            <td class="px-6 py-2 border-b border-gray-200 whitespace-nowrap">
                                <div class="text-sm font-medium leading-5 text-gray-900">
                                    {{ sale.codigo }}
                                </div>
                            </td>
                            <td class="px-6 py-2 border-b border-gray-200 whitespace-nowrap">
                                <div class="text-sm font-medium leading-5 text-gray-900">
                                    {{ sale.fechaEmision }}
                                </div>
                                <div class="text-sm leading-5 text-gray-900 whitespace-normal">
                                    {{ sale.metodoPago }}
                                </div>
                            </td>
                            <td class="px-6 py-2 border-b border-gray-200 whitespace-nowrap text-center">
                                <div class="text-sm font-medium leading-5 text-gray-900">
                                    {{ Intl.NumberFormat('es-CO', {
                                        style: 'currency', currency: 'COP'
                                    }).format(sale.impuestos) }}
                                </div>
                                <div class="text-sm leading-5 text-gray-900 whitespace-normal">
                                    {{ Intl.NumberFormat('es-CO', {
                                        style: 'currency', currency: 'COP'
                                    }).format(sale.subTotal) }}
                                </div>
                            </td>
                            <td class="px-6 py-2 border-b border-gray-200 whitespace-nowrap text-center">
                                <div class="text-sm font-medium leading-5 text-gray-900">
                                    {{ Intl.NumberFormat('es-CO', {
                                        style: 'currency', currency: 'COP'
                                    }).format(sale.total) }}
                                </div>
                            </td>
                            <td class="px-6 py-2 border-b border-gray-200 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center">
                                    <router-link :to="{ path: 'sales/show/' + sale.id }"
                                        class="text-blue-600 hover:text-blue-700 mr-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                            <path
                                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                        </svg>
                                    </router-link>

                                    <router-link :to="{ path: 'refunds/sales/' + sale.id }"
                                        class="text-red-600 hover:text-red-700 mr-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm11.5 5.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
                                        </svg>
                                    </router-link>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-2 ml-2">
            <v-pagination v-model="currentPage" :pages="totalPages" :range-size="2" active-color="#fff"
                @update:modelValue="loadData" />
        </div>
    </div>
</template>

<style scoped></style>