<script setup>
import { ref, onMounted, computed } from 'vue';
import { useAuthStore } from '../../auth.js';
import { component as VueNumber } from '@coders-tm/vue-number-format'
import { useRoute } from 'vue-router';
const route = useRoute();
const authStore = useAuthStore();
onMounted(() => { getSale() });
axios.defaults.headers.common['Authorization'] = 'Bearer ' + authStore.authToken;

const form = ref({});
const hasRefunds = ref(false);

const id = ref(route.params.id);
const getSale = () => {
    axios.get('/sales/' + id.value).then(response => {
        form.value = response.data.sale;
        hasRefunds.value = response.data.hasRefunds;
    });
};


const isTotalValid = () => {
    if (!form.value.product_sale) return false;

    // Calculamos el total sumando `precio_total` de cada producto
    const calculatedTotal = form.value.product_sale.reduce((total, product) => {
        return total + (parseFloat(product.pivot.precio_total) || 0);
    }, 0);

    // Comparamos el total calculado con el total en `form.value`
    return calculatedTotal === parseFloat(form.value.total || 0);
};

const openPDF = () => {
    axios({
        url: `/sales/${id.value}/pdf`,
        method: 'GET',
        responseType: 'blob',
    }).then((response) => {
        const fileURL = URL.createObjectURL(new Blob([response.data], { type: 'application/pdf' }));
        const printWindow = window.open(fileURL);

        setTimeout(() => {
            printWindow.print();
        }, 500);
    });
};

</script>

<template>
    <div class="flex justify-between items-center">
        <h3 class="sm:text-2xl text-lg font-semibold text-gray-700">
            Vista de Factura de Venta
        </h3>

        <div class="flex flex-col items-start w-26 sm:flex-row sm:items-center">
            <router-link
                class="inline-flex items-center text-xs mb-1 sm:mb-0 sm:mr-2 w-full px-2 h-8 bg-red-600 transition ease-in-out delay-75 hover:bg-red-700 text-white font-medium rounded-md"
                to="/sales">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-box-arrow-left h-4 w-4 mr-2"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z" />
                    <path fill-rule="evenodd"
                        d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z" />
                </svg>
                Regresar
            </router-link>
            <button @click="openPDF"
                class="inline-flex items-center text-xs mt-1 sm:mt-0 w-full px-2 h-8 bg-blue-600 transition ease-in-out delay-75 hover:bg-blue-700 text-white font-medium rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-floppy-fill h-4 w-4 mr-2"
                    viewBox="0 0 512 512">
                    <path
                        d="M128 0C92.7 0 64 28.7 64 64l0 96 64 0 0-96 226.7 0L384 93.3l0 66.7 64 0 0-66.7c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0L128 0zM384 352l0 32 0 64-256 0 0-64 0-16 0-16 256 0zm64 32l32 0c17.7 0 32-14.3 32-32l0-96c0-35.3-28.7-64-64-64L64 192c-35.3 0-64 28.7-64 64l0 96c0 17.7 14.3 32 32 32l32 0 0 64c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-64zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z" />
                </svg>
                Imprimir
            </button>
        </div>
    </div>

    <div v-if="hasRefunds" class="text-red-600 mt-2">
        Esta venta tiene devoluciones asociadas.
    </div>
    <div v-else class="text-green-600 mt-2">
        Esta venta no tiene devoluciones asociadas.
    </div>

    <div class="mt-6">
        <div class="px-4 pb-8 pt-5 bg-white shadow-md">
            <form>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div v-if="form.customer">
                        <label class="text-gray-700" for="customer_id">Cliente</label>
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
                                v-model="form.customer.NombreRazonSocial" autocomplete="off" disabled>
                        </div>
                    </div>

                    <div>
                        <label class="text-gray-700" for="codigo">Código</label>
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
                                v-model="form.codigo" autocomplete="off" disabled>
                        </div>
                    </div>

                    <div>
                        <label class="text-gray-700" for="fechaEmision">Fecha</label>
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
                            <input type="date"
                                class="w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0"
                                v-model="form.fechaEmision" autocomplete="off" disabled>
                        </div>
                    </div>

                    <div>
                        <label class="text-gray-700" for="metodoPago">Metodo de Pago</label>
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
                                v-model="form.metodoPago" disabled>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Nequi">Nequi</option>
                                <option value="Tarjeta">Tarjeta</option>
                                <option value="Credito">Credito</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="py-2 my-2 overflow-y-auto" v-show="form.product_sale">
                    <div
                        class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow rounded">
                        <table class="min-w-full overflow-x-auto" style="font-size: 0.6rem;">
                            <thead>
                                <tr>
                                    <th
                                        class="px-1 py-2 font-bold leading-4 tracking-wider text-left text-white uppercase bg-gray-900 border-b border-gray-200">
                                        Productos
                                    </th>
                                    <th
                                        class="px-1 py-2 w-20 font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200">
                                        Cantidad
                                    </th>
                                    <th
                                        class="px-1 py-2 w-28 font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200">
                                        Precio Unitario
                                    </th>
                                    <th
                                        class="px-1 py-2 w-20 font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200">
                                        Descuento
                                    </th>
                                    <th
                                        class="px-1 py-2 w-28 font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200">
                                        Valor Descuento
                                    </th>
                                    <th
                                        class="px-1 py-2 w-24 font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200">
                                        Impuestos
                                    </th>
                                    <th
                                        class="px-1 py-2 w-28 font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200">
                                        Subtotal
                                    </th>
                                    <th
                                        class="px-1 py-2 w-28 font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200">
                                        Precio Total
                                    </th>
                                </tr>
                            </thead>

                            <template v-if="!isTotalValid()">
                                <tr>
                                    <td colspan="8" class="px-1 py-1 text-center text-red-500">
                                        Borraste un producto, pendejo. Pero el saldo de la venta seguira existiendo
                                    </td>
                                </tr>
                            </template>
                            <tbody class="bg-white">
                                <tr v-for="(product, index) in form.product_sale" :key="index">
                                    <td class="px-1 py-1 border-b border-gray-200">
                                        <div class="font-medium text-gray-900">
                                            # {{ product.codigo }}
                                        </div>
                                        <div class="text-gray-900 whitespace-normal">
                                            {{ product.descripcion }}
                                        </div>
                                    </td>
                                    <td class="px-1 py-1 border-b border-gray-200 text-center">
                                        <input type="text"
                                            class="bg-white w-full h-0 py-3 rounded pl-2 text-base font-regular outline-0"
                                            style="font-size: 0.7rem" id="cantidad" v-model="product.pivot.cantidad"
                                            autocomplete="off" disabled>
                                    </td>
                                    <td class="px-1 py-1 border-b border-gray-200 text-center">
                                        <vue-number type="text"
                                            class="bg-white w-full h-0 py-3 rounded pl-2 text-base font-regular outline-0"
                                            style="font-size: 0.7rem" id="precio_unitario"
                                            v-model="product.pivot.precio_unitario" autocomplete="off"
                                            v-bind="{ prefix: '$ ', decimal: '.', separator: ',', minimumFractionDigits: 2 }"
                                            disabled></vue-number>
                                    </td>
                                    <td class="px-1 py-1 border-b border-gray-200 text-center ">
                                        <vue-number type="text"
                                            class=" bg-white w-full h-0 py-3 rounded pl-2 text-base font-regular outline-0"
                                            style="font-size: 0.7rem" id="descuento" v-model="product.pivot.descuento"
                                            autocomplete="off" v-bind="{ prefix: '% ' }" disabled></vue-number>
                                    </td>

                                    <td class="px-1 py-1 border-b border-gray-200 text-center ">
                                        <vue-number type="text"
                                            class=" bg-white w-full h-0 py-3 rounded pl-2 text-base font-regular outline-0"
                                            style="font-size: 0.7rem" id="valor_descuento"
                                            v-model="product.pivot.valor_descuento" autocomplete="off"
                                            v-bind="{ prefix: '$ ', decimal: '.', separator: ',', minimumFractionDigits: 2 }"
                                            disabled></vue-number>
                                    </td>

                                    <td class="px-1 py-1 border-b border-gray-200 text-center ">
                                        <vue-number type="text"
                                            class=" bg-white rounded w-full h-0 py-3 pl-2 text-base font-regular outline-0"
                                            style="font-size: 0.7rem" id="impuestos" v-model="product.pivot.impuestos"
                                            autocomplete="off"
                                            v-bind="{ prefix: '$ ', decimal: '.', separator: ',', minimumFractionDigits: 2 }"
                                            disabled>
                                        </vue-number>
                                    </td>
                                    <td class="px-1 py-1 border-b border-gray-200 text-center ">
                                        <vue-number type="text"
                                            class=" bg-white rounded w-full h-0 py-3 pl-2 text-base font-regular outline-0"
                                            style="font-size: 0.7rem" id="subtotal" v-model="product.pivot.subtotal"
                                            autocomplete="off"
                                            v-bind="{ prefix: '$ ', decimal: '.', separator: ',', minimumFractionDigits: 2 }"
                                            disabled>
                                        </vue-number>
                                    </td>
                                    <td class="px-1 py-1 border-b border-gray-200 text-center ">
                                        <vue-number type="text"
                                            class=" bg-white rounded w-full h-0 py-3 pl-2 text-base font-regular outline-0"
                                            style="font-size: 0.7rem" id="precio_total"
                                            v-model="product.pivot.precio_total" autocomplete="off"
                                            v-bind="{ prefix: '$ ', decimal: '.', separator: ',', minimumFractionDigits: 2 }"
                                            disabled>
                                        </vue-number>
                                    </td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right font-semibold px-6 py-2 bg-white">Total:</td>
                                    <td class="px-1 py-1 border-b border-gray-200 text-center ">
                                        <vue-number type="text"
                                            class=" bg-white w-full h-0 py-3 rounded pl-2 text-base font-regular outline-0"
                                            style="font-size: 0.7rem" id="" v-model="form.descuento_global"
                                            autocomplete="off" v-bind="{ prefix: '% ' }" disabled></vue-number>
                                    </td>
                                    <td class="px-1 py-1 border-b border-gray-200 text-center ">
                                        <vue-number type="text"
                                            class=" bg-white w-full h-0 py-3 rounded pl-2 text-base font-regular outline-0"
                                            style="font-size: 0.7rem" id="" v-model="form.valor_descuentoGlobal"
                                            autocomplete="off" v-bind="{ prefix: '$ ', minimumFractionDigits: 2 }"
                                            disabled></vue-number>
                                    </td>
                                    <td class="text-center font-semibold px-6 py-2 bg-white">
                                        {{ Intl.NumberFormat('es-CO', {
                                            style: 'currency', currency: 'COP'
                                        }).format(form.impuestos) }}
                                    </td>
                                    <td class="text-center font-semibold px-6 py-2 bg-white">
                                        {{ Intl.NumberFormat('es-CO', {
                                            style: 'currency', currency: 'COP'
                                        }).format(form.subTotal) }}
                                    </td>
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