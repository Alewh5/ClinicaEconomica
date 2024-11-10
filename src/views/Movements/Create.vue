<script setup>
import { ref, onMounted } from 'vue';
import { useAuthStore } from '../../auth.js';
import { sendRequest } from '../../function';
import { component as VueNumber } from '@coders-tm/vue-number-format'
const authStore = useAuthStore();

axios.defaults.headers.common['Authorization'] = 'Bearer ' + authStore.authToken;

const form = ref({ cellar_id: '', fecha: new Date().toISOString().split('T')[0], tipoMovimiento: 1, concepto: '', total: '', products: [] });

const cellars = ref([]);
const search = ref('');
const productosFiltrados = ref([]);

/* CARGA DE BODEGAS */
const getCellars = async (page) => {
    const response = await axios.get(`/cellars?page=${page}`);
    cellars.value = response.data.data;
}

/* LISTAR PRODUCTOS */
const buscarProducto = async () => {
    const response = await axios.get(`/products?search=${search.value}`);
    productosFiltrados.value = response.data.data;
}

const datalocal = ref([]);

const agregarProducto = (product) => {
    const existingProductIndex = form.value.products.findIndex(p => p.product_id === product.id);

    if (existingProductIndex !== -1) {
        form.value.products[existingProductIndex].cantidad++;
    } else {
        form.value.products.push({
            product_id: product.id,
            cantidad: 1,
            costo_unitario: '',
            costo_total: '',
        });

        datalocal.value.push({
            product_codigo: product.codigo,
            product_descripcion: product.descripcion,
            product_marca: product.marca,
            product_categoria: product.categoria,
        });
    }

    search.value = '';
}

const eliminarProducto = async (index) => {
    form.value.products.splice(index, 1);

    form.value.total = form.value.products.reduce((total, product) => {
        return total + product.costo_total;
    }, 0);
}

/* CALCULOS */

const calcularCostoTotal = async (product) => {
    product.costo_total = product.cantidad * product.costo_unitario;

    form.value.total = form.value.products.reduce((total, product) => {
        return total + product.costo_total;
    }, 0);
}

const formErrors = ref({});
const save = async () => {
    const { status, list_errors } = await sendRequest('POST', form.value, '/movements', '/products');
    if (status == 422) {
        formErrors.value = list_errors;
    }
}

onMounted(() => { getCellars(1) });
</script>

<template>
    <div class="flex justify-between items-center">
        <h3 class="sm:text-2xl text-lg font-semibold text-gray-700">
            Cargar o Descargar Productos
        </h3>

        <div class="flex flex-col items-start w-26 sm:flex-row sm:items-center">
            <router-link
                class="inline-flex items-center text-xs mb-1 sm:mb-0 sm:mr-2 w-full px-2 h-8 bg-green-600 transition ease-in-out delay-75 hover:bg-green-700 text-white font-medium rounded-md"
                to="/movements">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-box-arrow-left h-4 w-4 mr-2"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z" />
                    <path fill-rule="evenodd"
                        d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z" />
                </svg>
                Movimientos
            </router-link>
            <button @click="save"
                class="inline-flex items-center text-xs mt-1 sm:mt-0 w-full px-2 h-8 bg-blue-600 transition ease-in-out delay-75 hover:bg-blue-700 text-white font-medium rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-floppy-fill h-4 w-4 mr-2"
                    viewBox="0 0 16 16">
                    <path
                        d="M0 1.5A1.5 1.5 0 0 1 1.5 0H3v5.5A1.5 1.5 0 0 0 4.5 7h7A1.5 1.5 0 0 0 13 5.5V0h.086a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5H14v-5.5A1.5 1.5 0 0 0 12.5 9h-9A1.5 1.5 0 0 0 2 10.5V16h-.5A1.5 1.5 0 0 1 0 14.5z" />
                    <path
                        d="M3 16h10v-5.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5zm9-16H4v5.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5zM9 1h2v4H9z" />
                </svg>
                Guardar
            </button>
        </div>
    </div>

    <div class="mt-6">
        <div class="px-4 pb-8 pt-5 bg-white shadow-md">
            <form>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">

                    <div>
                        <label class="text-gray-700" for="cellar_id">Bodega <span v-if="formErrors['cellar_id']"
                                class="text-red-500 mt-1 text-sm">*</span></label>
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
                            <select class="w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0"
                                :class="{ 'border-red-500 border-2': formErrors['cellar_id'] }" id="cellar_id"
                                v-model="form.cellar_id">
                                <option value="" disabled>Selecciona una bodega</option>
                                <option v-for="cellar in cellars" :key="cellar.id" :value="cellar.id">{{ cellar.nombre }}
                                </option>
                                <option v-if="!cellars" disabled>No hay bodegas disponibles</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="text-gray-700" for="fecha">Fecha <span v-if="formErrors['fecha']"
                                class="text-red-500 mt-1 text-sm">*</span></label>
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
                            <input type="date" class="w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0"
                                :class="{ 'border-red-500 border-2': formErrors['fecha'] }" id="fecha" v-model="form.fecha"
                                autocomplete="off">
                        </div>
                    </div>

                    <div>
                        <label class="text-gray-700" for="tipoMovimiento">Tipo Movimiento <span
                                v-if="formErrors['tipoMovimiento']" class="text-red-500 mt-1 text-sm">*</span></label>
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
                            <select class="w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0"
                                :class="{ 'border-red-500 border-2': formErrors['tipoMovimiento'] }" id="tipoMovimiento"
                                v-model="form.tipoMovimiento">
                                <option value="1">Suministrar</option>
                                <option value="0">Desabastecer</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="text-gray-700" for="concepto">Concepto <span v-if="formErrors['concepto']"
                                class="text-red-500 mt-1 text-sm">*</span></label>
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
                            <input type="text" class="w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0"
                                :class="{ 'border-red-500 border-2': formErrors['concepto'] }" id="concepto"
                                v-model="form.concepto" autocomplete="off">
                        </div>
                    </div>

                </div>

                <div class="grid grid-cols-1 mt-6 sm:grid-cols-2 lg:grid-cols-2">
                    <div class="relative">
                        <label class="text-gray-700" for="searchProduct">Buscar Productos <span
                                v-if="formErrors['products']" class="text-red-500 mt-1 text-sm">*</span></label>
                        <div class="flex mt-2">
                            <div
                                class="flex items-center justify-center rounded-tl-lg rounded-bl-lg border-y border-l relative border-gray-400 bg-white p-5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    class="bi bi-search-heart pointer-events-none absolute w-5 h-5 fill-gray-500 transition"
                                    viewBox="0 0 16 16">
                                    <path d="M6.5 4.482c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.69 0-5.018" />
                                    <path
                                        d="M13 6.5a6.47 6.47 0 0 1-1.258 3.844q.06.044.115.098l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1-.1-.115h.002A6.5 6.5 0 1 1 13 6.5M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11" />
                                </svg>
                            </div>
                            <input type="text" class="w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0"
                                :class="{ 'border-red-500 border-2': formErrors['products'] }" id="searchProduct"
                                v-model="search" autocomplete="off" @input="buscarProducto">
                        </div>
                        <!-- Mostrar productos filtrados -->
                        <div v-if="search.length > 0"
                            class="mt-4 absolute top-16 bg-white border rounded border-gray-300 w-full overflow-y-auto">
                            <ul>
                                <li v-for="(product, index) in productosFiltrados.slice(0, 5)" :key="index"
                                    class="text-gray-700 border-b border-gray-300 p-2 flex items-center justify-between">
                                    <span class="font-medium">
                                        {{ product.descripcion }} - <span
                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">$
                                            {{
                                                product.precio }}</span></span>
                                    <button @click="agregarProducto(product)"
                                        class="ml-2 bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">Agregar</button>
                                </li>
                            </ul>
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
                                    <th
                                        class="px-6 py-2 text-xs font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200">
                                        Costo Unitario
                                    </th>
                                    <th
                                        class="px-6 py-2 text-xs font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200">
                                        Costo Total
                                    </th>
                                    <th
                                        class="px-6 py-2 text-xs font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white">
                                <tr v-for="(product, index) in form.products" :key="index">
                                    <td class="px-6 py-2 border-b border-gray-200 whitespace-nowrap">
                                        <div class="text-sm font-medium leading-5 text-gray-900">
                                            COD: {{ datalocal[index].product_codigo }}
                                        </div>
                                        <div class="text-sm leading-5 text-gray-900 whitespace-normal">
                                            {{ datalocal[index].product_descripcion }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-2 border-b border-gray-200 whitespace-nowrap">
                                        <div class="text-sm leading-5 text-gray-900">
                                            <span class="font-semibold">MARCA:</span> {{ datalocal[index].product_marca }}
                                        </div>
                                        <div class="text-sm leading-5 text-gray-900">
                                            <span class="font-semibold">CATEGORIA:</span> {{
                                                datalocal[index].product_categoria }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-2 border-b border-gray-200 whitespace-nowrap text-center">
                                        <input type="text"
                                            class="w-full bg-white rounded pl-2 text-base font-regular outline-0"
                                            :class="{ 'border-red-500 border-2': formErrors['products.' + index + '.cantidad'] }"
                                            id="cantidad" v-model="product.cantidad" autocomplete="off"
                                            @change="calcularCostoTotal(product)">
                                    </td>
                                    <td class="px-1 py-4 border-b border-gray-200 whitespace-nowrap text-center">
                                        <vue-number type="text"
                                            class="w-full bg-white rounded pl-2 text-base font-regular outline-0"
                                            :class="{ 'border-red-500 border-2': formErrors['products.' + index + '.costo_unitario'] }"
                                            id="costo_unitario" v-model="product.costo_unitario" autocomplete="off"
                                            v-bind="{ prefix: '$ ', decimal: '.', separator: ',', minimumFractionDigits: 2 }"
                                            @change="calcularCostoTotal(product)"></vue-number>
                                    </td>
                                    <td class="px-1 py-4 border-b border-gray-200 whitespace-nowrap text-center">
                                        <vue-number type="text"
                                            class="w-full bg-white rounded text-base font-regular outline-0"
                                            :class="{ 'border-red-500 border-2': formErrors['products.' + index + '.costo_total'] }"
                                            id="costo_total" v-model="product.costo_total" autocomplete="off"
                                            v-bind="{ prefix: '$ ', decimal: '.', separator: ',', minimumFractionDigits: 2 }"
                                            @change="calcularCostoTotal(product)" disabled></vue-number>
                                    </td>
                                    <td class="px-1 py-2 border-b border-gray-200 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center">
                                            <a @click="eliminarProducto(index)"
                                                class="text-red-500 cursor-pointer hover:text-red-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                    <path
                                                        d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <!-- Pie de tabla -->
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right font-semibold px-6 py-2 bg-white">Total:</td>
                                    <td class="text-center font-semibold px-6 py-2 bg-white">
                                        {{ Intl.NumberFormat('es-CO', {
                                            style: 'currency', currency: 'COP'
                                        }).format(form.total) }}
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </form>
        </div>
    </div>
</template>