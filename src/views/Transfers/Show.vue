<script setup>
import { ref, onMounted } from 'vue';
import { useAuthStore } from '../../auth.js';
import { sendRequest } from '../../function';
import { component as VueNumber } from '@coders-tm/vue-number-format'
import { useRoute } from 'vue-router';
const route = useRoute();
const authStore = useAuthStore();

axios.defaults.headers.common['Authorization'] = 'Bearer ' + authStore.authToken;

const form = ref({});

const id = ref(route.params.id);
const getTransfer = () => {
    axios.get('/transfers/' + id.value).then(
        response => (form.value = response.data)
    )
}

onMounted(() => { getTransfer() });
</script>

<template>
    <div class="flex justify-between items-center">
        <h3 class="sm:text-2xl text-lg font-semibold text-gray-700">
            Vista de Traslado entre Bodegas
        </h3>

        <div class="flex flex-col items-start w-26 sm:flex-row sm:items-center">
            <router-link
                class="inline-flex items-center text-xs mb-1 sm:mb-0 sm:mr-2 w-full px-2 h-8 bg-yellow-500 transition ease-in-out delay-75 hover:bg-yellow-700 text-white font-medium rounded-md"
                to="/transfers">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-box-arrow-left h-4 w-4 mr-2"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z" />
                    <path fill-rule="evenodd"
                        d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z" />
                </svg>
                Traslados
            </router-link>
        </div>
    </div>

    <div class="mt-6">
        <div class="px-4 pb-8 pt-5 bg-white shadow-md">
            <form>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">

                    <div v-if="form.cellar_origen">
                        <label class="text-gray-700" for="cellar_origen_id">Bodega Origen</label>
                        <div class="flex mt-2">
                            <div
                                class="flex items-center justify-center rounded-tl-lg rounded-bl-lg border-y border-l relative border-gray-400 bg-white p-5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    class="bi bi-check2-square pointer-events-none absolute w-5 h-5 fill-gray-500 transition"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5z" />
                                    <path
                                        d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0" />
                                </svg>
                            </div>
                            <input type="text"
                                class="w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0"
                                id="cellar_origen_id" v-model="form.cellar_origen.nombre" disabled autocomplete="off">
                        </div>
                    </div>

                    <div>
                        <label class="text-gray-700" for="fecha_traslado">Fecha</label>
                        <div class="flex mt-2">
                            <div
                                class="flex items-center justify-center rounded-tl-lg rounded-bl-lg border-y border-l relative border-gray-400 bg-white p-5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    class="bi bi-calendar-check pointer-events-none absolute w-5 h-5 fill-gray-500 transition"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                                    <path
                                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                                </svg>
                            </div>
                            <input type="date"
                                class="w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0"
                                id="fecha_traslado" v-model="form.fecha_traslado" disabled autocomplete="off">
                        </div>
                    </div>

                    <div v-if="form.cellar_origen">
                        <label class="text-gray-700" for="cellar_destino_id">Bodega Destino</label>
                        <div class="flex mt-2">
                            <div
                                class="flex items-center justify-center rounded-tl-lg rounded-bl-lg border-y border-l relative border-gray-400 bg-white p-5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    class="bi bi-check2-square pointer-events-none absolute w-5 h-5 fill-gray-500 transition"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5z" />
                                    <path
                                        d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0" />
                                </svg>
                            </div>
                            <input type="text"
                                class="w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0"
                                id="cellar_destino_id" v-model="form.cellar_destino.nombre" disabled autocomplete="off">
                        </div>
                    </div>

                    <div>
                        <label class="text-gray-700" for="detalles">Detalles</label>
                        <div class="flex mt-2">
                            <div
                                class="flex items-center justify-center rounded-tl-lg rounded-bl-lg border-y border-l relative border-gray-400 bg-white p-5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    class="bi bi-alphabet-uppercase pointer-events-none absolute w-5 h-5 fill-gray-500 transition"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M1.226 10.88H0l2.056-6.26h1.42l2.047 6.26h-1.29l-.48-1.61H1.707l-.48 1.61ZM2.76 5.818h-.054l-.75 2.532H3.51zm3.217 5.062V4.62h2.56c1.09 0 1.808.582 1.808 1.54 0 .762-.444 1.22-1.05 1.372v.055c.736.074 1.365.587 1.365 1.528 0 1.119-.89 1.766-2.133 1.766zM7.18 5.55v1.675h.8c.812 0 1.171-.308 1.171-.853 0-.51-.328-.822-.898-.822zm0 2.537V9.95h.903c.951 0 1.342-.312 1.342-.909 0-.591-.382-.954-1.095-.954zm5.089-.711v.775c0 1.156.49 1.803 1.347 1.803.705 0 1.163-.454 1.212-1.096H16v.12C15.942 10.173 14.95 11 13.607 11c-1.648 0-2.573-1.073-2.573-2.849v-.78c0-1.775.934-2.871 2.573-2.871 1.347 0 2.34.849 2.393 2.087v.115h-1.172c-.05-.665-.516-1.156-1.212-1.156-.849 0-1.347.67-1.347 1.83" />
                                </svg>
                            </div>
                            <input type="text"
                                class="w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0"
                                :id="detalles" disabled v-model="form.detalles" autocomplete="off">
                        </div>
                    </div>

                </div>

                <div class="py-2 my-2 overflow-x-auto overflow-y-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                    <div
                        class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow rounded">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-2 text-xs font-bold leading-4 tracking-wider text-left text-white uppercase bg-gray-900 border-b border-gray-200">
                                        Productos
                                    </th>
                                    <th
                                        class="px-6 py-2 text-xs font-bold leading-4 tracking-wider text-left text-white uppercase bg-gray-900 border-b border-gray-200">
                                        Detalles
                                    </th>
                                    <th
                                        class="px-6 py-2 text-xs font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200">
                                        Cantidad
                                    </th>
                                </tr>
                            </thead>

                            <template v-if="Array.isArray(form.transfer_product) && form.transfer_product.length === 0">
                                <tr>
                                    <td colspan="8" class="px-1 py-1 text-center text-red-500">
                                        Borraste productos, pendejo. Pero el traslado sigue existiendo.
                                    </td>
                                </tr>
                            </template>
                            <tbody class="bg-white">
                                <tr v-for="(product, index) in form.transfer_product" :key="index">
                                    <td class="px-6 py-2 border-b border-gray-200 whitespace-nowrap">
                                        <div class="text-sm font-medium leading-5 text-gray-900">
                                            COD: {{ product.codigo }}
                                        </div>
                                        <div class="text-sm leading-5 text-gray-900 whitespace-normal">
                                            {{ product.descripcion }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-2 border-b border-gray-200 whitespace-nowrap">
                                        <div class="text-sm leading-5 text-gray-900">
                                            <span class="font-semibold">MARCA:</span> {{ product.marca }}
                                        </div>
                                        <div class="text-sm leading-5 text-gray-900">
                                            <span class="font-semibold">CATEGORIA:</span> {{
                                                product.categoria }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-2 border-b border-gray-200 whitespace-nowrap text-center">
                                        <input type="text"
                                            class="w-full bg-white rounded pl-2 text-base font-regular outline-0"
                                            id="cantidad" v-model="product.pivot.cantidad" autocomplete="off" disabled>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </form>
        </div>
    </div>
</template>