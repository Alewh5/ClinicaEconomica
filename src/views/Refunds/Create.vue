<script setup>
import { ref, onMounted } from 'vue';
import { useAuthStore } from '../../auth.js';
import { sendRequest } from '../../function';
import { component as VueNumber } from '@coders-tm/vue-number-format'
import { useRoute } from 'vue-router';
const route = useRoute();
const authStore = useAuthStore();

axios.defaults.headers.common['Authorization'] = 'Bearer ' + authStore.authToken;

/* VARIABLES */

// DATOS DE LA VENTA
const formSale = ref({
    customer_id: '',
    provider_id: '',
    codigo: '',
    fechaEmision: '',
    metodoPago: '',
    subTotal: '',
    impuestos: '',
    total: '',
    descuento_global: '',
    valor_descuentoGlobal: '',
    descuento_total: '',
    products: []
});


const data = ref([]);

const formCustomer = ref({
    tipoDocumento: '',
    numeroDocumento: '',
    NombreRazonSocial: '',
    direccion: '',
    telefono: '',
    email: '',
    departamento: '',
    municipio: ''
});

const id = ref(route.params.id);
const getDatos = () => {
    if (route.name === 'Refunds-Invoices-Create') {
        axios.get('/invoices/' + id.value).then(
            response => {
                formSale.value = response.data.invoice;
                formSale.value.products = response.data.invoice.product_invoice;
                formCustomer.value = response.data.invoice.provider;
                cantidad.value = new Array(formSale.value.products.length).fill(0);

                formSale.value.products.forEach((product, index) => {
                    addProduct(product, index);
                });
            }
        )
    }
    if (route.name === 'Refunds-Sales-Create') {
        axios.get('/sales/' + id.value).then(
            response => {
                formSale.value = response.data.sale;
                formSale.value.products = response.data.sale.product_sale;
                formCustomer.value = response.data.sale.customer;
                cantidad.value = new Array(formSale.value.products.length).fill(0);

                formSale.value.products.forEach((product, index) => {
                    addProduct(product, index);
                });
            }
        )
    }

};

const cantidad = ref([]);

const addProduct = async (product, index) => {
    const existingProductIndex = form.value.products.findIndex(p => p.product_id === product.id);
    const Total = formSale.value.products[index].pivot.precio_total;
    const cantidad_devolver = cantidad.value[index];

    calcularTotalesProducto(product, index);

    if (existingProductIndex !== -1) {
        form.value.products[existingProductIndex].cantidad = cantidad_devolver;
        form.value.products[existingProductIndex].precio_total = Total - data.value[index];
    } else {
        form.value.products.push({
            product_id: product.id,
            cantidad: cantidad_devolver,
            precio_total: Total - data.value[index]
        });
    }

    form.value.total = form.value.products.reduce((total, product) => {
        return total + parseFloat(product.precio_total);
    }, 0);
};


onMounted(() => { getDatos() });

//CALCULAR

const calcularTotalesVenta = () => {

    formSale.value.descuento_total = formSale.value.products.reduce((total, product) => {
        return total + parseFloat(product.pivot.valor_descuento);
    }, 0);

    formSale.value.impuestos = formSale.value.products.reduce((total, product) => {
        return total + parseFloat(product.pivot.impuestos);
    }, 0);

    formSale.value.subTotal = formSale.value.products.reduce((total, product) => {
        return total + parseFloat(product.pivot.subtotal);
    }, 0);

    const descuentoGlobal = parseFloat(formSale.value.descuento_global);
    const descuentoGlobalValor = (formSale.value.subTotal * descuentoGlobal) / 100;

    formSale.value.valor_descuentoGlobal = descuentoGlobalValor;

    formSale.value.subTotal = formSale.value.subTotal - descuentoGlobalValor;

    formSale.value.total = formSale.value.subTotal + formSale.value.impuestos;
};


const calcularTotalesProducto = (product, index) => {
    const cantidadExacta = (product.pivot.cantidad - cantidad.value[index]);
    const impuestos = (cantidadExacta * ((product.pivot.precio_unitario * product.iva_venta) / 100));
    const valorDescuento = (((cantidadExacta * product.pivot.precio_unitario)) * product.pivot.descuento) / 100;
    const subtotal = ((cantidadExacta * product.pivot.precio_unitario)) - valorDescuento;

    product.pivot.impuestos = impuestos;
    product.pivot.valor_descuento = valorDescuento;
    product.pivot.subtotal = subtotal;
    data.value[index] = subtotal + impuestos;

    calcularTotalesVenta();
};


// METODO SAVE DE SALES

const title = ref('');
const form = ref({
    sale_id: '',
    invoice_id: '',
    motivo: '',
    fecha: new Date().toISOString().split('T')[0],
    total: '',
    products: []
});

if (route.name === 'Refunds-Invoices-Create') {
    form.value.invoice_id = id.value;
    formSale.value.provider_id = formSale.value.customer_id;
    title.value = 'Realizar Devolución en Compra'
} else if (route.name === 'Refunds-Sales-Create') {
    form.value.sale_id = id.value;
    formSale.value.customer_id = formSale.value.customer_id;
    title.value = 'Realizar Devolución en Venta'
}

const formErrors = ref({});
const save = async () => {
    const { status, list_errors } = await sendRequest('POST', form.value, '/refunds', '/refunds');
    if (status == 422) {
        formErrors.value = list_errors;
    }
}
</script>

<template>
    <div class="flex justify-between items-center">
        <h3 class="sm:text-2xl text-lg font-semibold text-gray-700">{{ title }}</h3>

        <div class="flex flex-col items-start w-26 sm:flex-row sm:items-center">
            <router-link
                class="inline-flex items-center text-xs mb-1 sm:mb-0 sm:mr-2 w-full px-2 h-8 bg-red-500 transition ease-in-out delay-75 hover:bg-red-700 text-white font-medium rounded-md"
                to="/refunds">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-box-arrow-left h-4 w-4 mr-2"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z" />
                    <path fill-rule="evenodd"
                        d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z" />
                </svg>
                Devoluciones
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
                        <label class="text-gray-700" for="fecha">Fecha <span v-if="formErrors['fecha']"
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
                            <input type="date"
                                class="w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0"
                                :class="{ 'border-red-500 border-2': formErrors['fecha'] }" id="fecha"
                                v-model="form.fecha" autocomplete="off">
                        </div>
                    </div>

                    <div>
                        <label class="text-gray-700" for="motivo">Motivo <span v-if="formErrors['motivo']"
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
                            <input type="text"
                                class="w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0"
                                :class="{ 'border-red-500 border-2': formErrors['motivo'] }" id="motivo"
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
                                        class="px-1 py-2 font-bold leading-4 tracking-wider text-left text-white uppercase bg-gray-900 border-b border-gray-200">
                                        Productos
                                    </th>
                                    <th
                                        class="px-1 py-2 w-20 font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200">
                                        Cantidad
                                    </th>
                                    <th
                                        class="px-1 py-2 w-20 font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200">
                                        Devolver
                                    </th>
                                    <th
                                        class="px-1 py-2 w-28 font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200">
                                        Precio Unitario
                                    </th>
                                    <th
                                        class="px-1 py-2 w-28 font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200">
                                        Valor a Devolver
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
                                <tr v-for="(product, index) in formSale.products" :key="index">
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
                                        <input type="text"
                                            class="bg-white w-full h-0 py-3 rounded pl-2 text-base font-regular outline-0"
                                            style="font-size: 0.7rem" id="cantida_devolver" v-model="cantidad[index]"
                                            :class="{ 'border-red-500 border-2': formErrors['products.' + index + '.cantidad'] }"
                                            @input="addProduct(product, index)" autocomplete="off">
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
                                            class="bg-gray-300 w-full h-0 py-3 rounded pl-2 text-base font-regular outline-0"
                                            style="font-size: 0.7rem" id="descuento"
                                            :class="{ 'border-red-500 border-2': formErrors['products.' + index + '.precio_total'] }"
                                            v-model="form.products[index].precio_total" autocomplete="off"
                                            v-bind="{ prefix: '$ ', decimal: '.', separator: ',', minimumFractionDigits: 2 }"
                                            disabled></vue-number>
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
                                    <td v-if="data[index] !== undefined"
                                        class="px-1 py-1 border-b border-gray-200 text-center ">
                                        <vue-number type="text"
                                            class=" bg-white rounded w-full h-0 py-3 pl-2 text-base font-regular outline-0"
                                            style="font-size: 0.7rem" id="precio_total" v-model="data[index]"
                                            autocomplete="off"
                                            v-bind="{ prefix: '$ ', decimal: '.', separator: ',', minimumFractionDigits: 2 }"
                                            disabled>
                                        </vue-number>
                                    </td>
                                    <td v-else class="px-1 py-1 border-b border-gray-200 text-center ">
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
                                    <td colspan="4" class="text-right font-semibold px-6 py-2 bg-white">Totales:</td>
                                    <td class="px-1 py-1 border-b border-gray-200 text-center ">
                                        <vue-number type="text"
                                            class=" bg-white w-full h-0 py-3 rounded pl-2 text-base font-regular outline-0"
                                            style="font-size: 0.7rem" v-model="form.total" autocomplete="off"
                                            :class="{ 'border-red-500 border-2': formErrors['total'] }"
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