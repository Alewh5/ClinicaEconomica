<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useAuthStore } from '../../auth.js';
import { confirmation, sendRequest } from '../../function';
import VPagination from "@hennge/vue3-pagination";

const authStore = useAuthStore();

axios.defaults.headers.common['Authorization'] = 'Bearer ' + authStore.authToken;

const cellars = ref([]);
const search = ref('');

//PAGINATION
let load = ref(false);
let currentPage = ref();
let totalRecords = ref(0);
let totalPages = ref();
let perPage = ref(5);

const getCellars = async (page) => {
    const response = await axios.get(`/cellars?
    page=${page}&per_page=${perPage.value}&search=${search.value}`);
    cellars.value = response.data.data;
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

    await getCellars(currentPage.value);
}

/* PREDETERMINAR BODEGA */
const setDefault = async (cellarId) => {
    const { status } = await sendRequest('POST', {}, '/cellars/' + cellarId, '');
    if (status === 200) {
        await loadData();
    }
}

/* DELETE ITEMS */
const deleteItem = async (id, name) => {
    confirmation(name, ('/cellars/' + id), '', async () => {
        await loadData(1);
    });
}

onMounted(() => { loadData(1) });
</script>

<template>
    <h3 class="flex items-center text-2xl mb-2 font-semibold text-gray-700">
        Listado de Bodegas
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
        <div class="flex flex-row w-full items-center">
            <div class="flex">
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
            <div class="relative block">
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
                class="inline-flex items-center w-full sm:mb-0 mb-1 px-2 py-1 ml-2 bg-yellow-500 transition ease-in-out delay-75 hover:bg-yellow-600 text-white text-sm font-medium rounded-md"
                to="/transfers/create">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    class="bi bi-arrows-expand-vertical mr-2 h-4 w-4" viewBox="0 0 16 16">
                    <path
                        d="M8 15a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5M.146 8.354a.5.5 0 0 1 0-.708l2-2a.5.5 0 1 1 .708.708L1.707 7.5H5.5a.5.5 0 0 1 0 1H1.707l1.147 1.146a.5.5 0 0 1-.708.708zM10 8a.5.5 0 0 1 .5-.5h3.793l-1.147-1.146a.5.5 0 0 1 .708-.708l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L14.293 8.5H10.5A.5.5 0 0 1 10 8" />
                </svg>
                Trasladar
            </router-link>

            <router-link
                class="inline-flex items-center w-full sm:mt-0 mt-1 px-2 py-1 ml-2 bg-blue-600 transition ease-in-out delay-75 hover:bg-blue-700 text-white text-sm font-medium rounded-md"
                to="/cellars/create">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-plus-circle-fill mr-2 h-4 w-4"
                    viewBox="0 0 16 16">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                </svg>
                Agregar
            </router-link>
        </div>
    </div>

    <div class="flex flex-col mt-6" v-show="load">
        <div class="py-2 -my-2 overflow-x-auto overflow-y-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow rounded">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th
                                class="px-6 py-2 text-xs font-bold leading-4 tracking-wider text-left text-white uppercase bg-gray-900 border-b border-gray-200">
                                Nombre
                            </th>
                            <th
                                class="px-6 py-2 text-xs font-bold leading-4 tracking-wider text-left text-white uppercase bg-gray-900 border-b border-gray-200">
                                Ubicación
                            </th>
                            <th
                                class="px-6 py-2 text-xs font-bold leading-4 tracking-wider text-left text-white uppercase bg-gray-900 border-b border-gray-200">
                                Detalles
                            </th>
                            <th
                                class="px-6 py-2 text-xs font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200">
                                Predeterminada
                            </th>
                            <th
                                class="px-6 py-2 text-xs font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200">
                                Acciones
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white">
                        <tr v-for="(cellar, index) in cellars" :key="cellar.id">
                            <td class="px-6 py-2 border-b border-gray-200 whitespace-nowrap">
                                <div class="text-sm leading-5 text-gray-900">
                                    {{ cellar.nombre }}
                                </div>
                            </td>
                            <td class="px-6 py-2 border-b border-gray-200 whitespace-nowrap">
                                <div class="text-sm leading-5 text-gray-900">
                                    {{ cellar.ubicacion }}
                                </div>
                            </td>
                            <td class="px-6 py-2 border-b border-gray-200 whitespace-nowrap">
                                <div class="text-sm leading-5 text-gray-900">
                                    {{ cellar.detalles }}
                                </div>
                            </td>
                            <td class="px-6 py-2 border-b border-gray-200 whitespace-nowrap text-center">
                                <input type="checkbox" :id="'predeterminado_' + cellar.id"
                                    class="w-5 h-5 text-indigo-600 rounded-md focus:ring-indigo-500" name="predeterminado"
                                    :checked="cellar.predeterminada" @change="setDefault(cellar.id)"
                                    :disabled="cellar.predeterminada">
                            </td>
                            <td class="px-6 py-2 border-b border-gray-200 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center">
                                    <router-link :to="{ path: 'cellars/edit/' + cellar.id }"
                                        class="text-yellow-400 hover:text-yellow-600 mr-2">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                            <path fill-rule="evenodd"
                                                d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </router-link>

                                    <a @click="deleteItem(cellar.id, cellar.nombre)"
                                        class="text-red-500 cursor-pointer hover:text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                        </svg>
                                    </a>
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