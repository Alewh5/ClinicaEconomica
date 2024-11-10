<script setup>
import { ref, onMounted } from 'vue';
import { useAuthStore } from '../../auth.js';
import { component as VueNumber } from '@coders-tm/vue-number-format'
import { useRoute } from 'vue-router';
const route = useRoute();
const authStore = useAuthStore();
onMounted(() => { getRefund() });
axios.defaults.headers.common['Authorization'] = 'Bearer ' + authStore.authToken;

const form = ref({});
const formProducts = ref({});
const formSale = ref({});
const formCustomer = ref({});
let isValid = Boolean;

const id = ref(route.params.id);
const getRefund = () => {
    axios.get('/refunds/' + id.value).then(response => {
        form.value = response.data.refund.amount;
        formProducts.value = response.data.refund;
        formSale.value = response.data.relatedData;
        if (response.data.relatedData.customer) {
            formCustomer.value = response.data.relatedData.customer;
        } else if (response.data.relatedData.provider) {
            formCustomer.value = response.data.relatedData.provider;
        }
    });
};

</script>

<template>
    <div class="flex justify-between items-center">
        <h3 class="sm:text-2xl text-lg font-semibold text-gray-700">Devolucion Nº {{ form.id }}</h3>
    </div>

    <div class="mt-4">
        <div class="px-4 pb-8 pt-5 bg-white shadow-md">
            <form>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">

                    <div>
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
                                v-model="formCustomer.NombreRazonSocial" autocomplete="off">
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
                                v-model="formSale.codigo" autocomplete="off">
                        </div>
                    </div>

                    <div>
                        <label class="text-gray-700" for="fecha">Fecha</label>
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
                                class="w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0" id="fecha"
                                v-model="form.fecha" autocomplete="off">
                        </div>
                    </div>

                    <div>
                        <label class="text-gray-700" for="motivo">Motivo</label>
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
                                class="w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0" id="motivo"
                                v-model="form.motivo" autocomplete="off">
                        </div>
                    </div>

                </div>

                <div class="py-2 my-2 overflow-y-auto">
                    <div
                        class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow rounded">
                        <table class="min-w-full overflow-x-auto" style="font-size: 0.6rem;">
                            <thead>
                                <tr>
                                    <th
                                        class="px-1 py-2 w-36 font-bold leading-4 tracking-wider text-left text-white uppercase bg-gray-900 border-b border-gray-200">
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

                            <tbody class="bg-white">
                                <tr v-for="(product, index) in formProducts.product_refund" :key="index">
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
                                            style="font-size: 0.7rem" id="cantidad" v-model="product.cantidad"
                                            autocomplete="off" disabled>
                                    </td>
                                    <td class="px-1 py-1 border-b border-gray-200 text-center">
                                        <vue-number type="text"
                                            class="bg-white w-full h-0 py-3 rounded pl-2 text-base font-regular outline-0"
                                            style="font-size: 0.7rem" id="precio_unitario"
                                            v-model="product.precio_unitario" autocomplete="off"
                                            v-bind="{ prefix: '$ ', decimal: '.', separator: ',', minimumFractionDigits: 2 }"
                                            disabled></vue-number>
                                    </td>

                                    <td class="px-1 py-1 border-b border-gray-200 text-center ">
                                        <vue-number type="text"
                                            class="bg-gray-300 w-full h-0 py-3 rounded pl-2 text-base font-regular outline-0"
                                            style="font-size: 0.7rem" id="descuento"
                                            v-model="product.valor_descuento" autocomplete="off"
                                            v-bind="{ prefix: '$ ', decimal: '.', separator: ',', minimumFractionDigits: 2 }"
                                            disabled></vue-number>
                                    </td>

                                    <td class="px-1 py-1 border-b border-gray-200 text-center ">
                                        <vue-number type="text"
                                            class=" bg-white w-full h-0 py-3 rounded pl-2 text-base font-regular outline-0"
                                            style="font-size: 0.7rem" id="valor_descuento"
                                            v-model="product.impuestos" autocomplete="off"
                                            v-bind="{ prefix: '$ ', decimal: '.', separator: ',', minimumFractionDigits: 2 }"
                                            disabled></vue-number>
                                    </td>
                                    <td class="px-1 py-1 border-b border-gray-200 text-center ">
                                        <vue-number type="text"
                                            class=" bg-white rounded w-full h-0 py-3 pl-2 text-base font-regular outline-0"
                                            style="font-size: 0.7rem" id="subtotal" v-model="product.subtotal"
                                            autocomplete="off"
                                            v-bind="{ prefix: '$ ', decimal: '.', separator: ',', minimumFractionDigits: 2 }"
                                            disabled>
                                        </vue-number>
                                    </td>
                                    <td class="px-1 py-1 border-b border-gray-200 text-center ">
                                        <vue-number type="text"
                                            class=" bg-white rounded w-full h-0 py-3 pl-2 text-base font-regular outline-0"
                                            style="font-size: 0.7rem" id="precio_total"
                                            v-model="product.precio_total" autocomplete="off"
                                            v-bind="{ prefix: '$ ', decimal: '.', separator: ',', minimumFractionDigits: 2 }"
                                            disabled>
                                        </vue-number>
                                    </td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-right font-semibold px-6 py-2 bg-white">Totales:</td>
                                    <td class="px-1 py-1 border-b border-gray-200 text-center ">
                                        <vue-number type="text"
                                            class=" bg-white w-full h-0 py-3 rounded pl-2 text-base font-regular outline-0"
                                            style="font-size: 0.7rem" v-model="form.total" autocomplete="off"
                                            v-bind="{ prefix: '$ ', decimal: '.', separator: ',', minimumFractionDigits: 2 }"
                                            disabled></vue-number>
                                    </td>
                                    <td class="px-1 py-1 border-b border-gray-200 text-center ">
                                        <vue-number type="text"
                                            class=" bg-white w-full h-0 py-3 rounded pl-2 text-base font-regular outline-0"
                                            style="font-size: 0.7rem" v-model="formSale.valor_descuentoGlobal"
                                            autocomplete="off" v-bind="{ prefix: '$ ', minimumFractionDigits: 2 }"
                                            disabled></vue-number>
                                    </td>
                                    <td class="text-center font-semibold px-6 py-2 bg-white">
                                        {{ Intl.NumberFormat('es-CO', {
                                            style: 'currency', currency: 'COP'
                                        }).format(formSale.impuestos) }}
                                    </td>
                                    <td class="text-center font-semibold px-6 py-2 bg-white">
                                        {{ Intl.NumberFormat('es-CO', {
                                            style: 'currency', currency: 'COP'
                                        }).format(formSale.subTotal) }}
                                    </td>
                                    <td class="text-center font-semibold px-6 py-2 bg-white">
                                        {{ Intl.NumberFormat('es-CO', {
                                            style: 'currency', currency: 'COP'
                                        }).format(formSale.total) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>