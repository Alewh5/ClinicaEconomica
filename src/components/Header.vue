<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useSidebar } from '../composables/useSidebar'
import { useAuthStore } from '../auth.js';
const authStore = useAuthStore();

const dropdownOpen = ref(false)
const { isOpen } = useSidebar()

axios.defaults.headers.common['Authorization'] = 'Bearer ' + authStore.authToken;

const getPresupuesto = async () => {
  const response = await axios.get(`/companies/${authStore.authCompany.id}`);
  if (response.status === 200) {
    authStore.authCompany.presupuesto = response.data.presupuesto;
  }
}

onMounted(() => {
  getPresupuesto();
  setInterval(getPresupuesto, 60000);
});
</script>

<template>
  <header class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-gray-900">
    <div class="flex items-center">
      <button class="text-gray-500 focus:outline-none lg:hidden" @click="isOpen = true">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" />
        </svg>
      </button>
    </div>

    <div class="flex items-center">
      <router-link :to="{ name: 'Budget' }"><span class="font-bold">Presupuesto: </span>{{ Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(authStore.company.presupuesto) }}</router-link>

      <button class="flex mx-4 text-gray-600 focus:outline-none">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M15 17H20L18.5951 15.5951C18.2141 15.2141 18 14.6973 18 14.1585V11C18 8.38757 16.3304 6.16509 14 5.34142V5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5V5.34142C7.66962 6.16509 6 8.38757 6 11V14.1585C6 14.6973 5.78595 15.2141 5.40493 15.5951L4 17H9M15 17V18C15 19.6569 13.6569 21 12 21C10.3431 21 9 19.6569 9 18V17M15 17H9"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </button>

      <div class="relative">
        <button class="relative z-10 block w-8 h-8 overflow-hidden rounded-full shadow focus:outline-none"
          @click="dropdownOpen = !dropdownOpen">
          <img class="object-cover w-full h-full"
            src="https://images.unsplash.com/photo-1528892952291-009c663ce843?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=296&q=80"
            alt="Your avatar">
        </button>

        <div v-show="dropdownOpen" class="fixed inset-0 z-10 w-full h-full" @click="dropdownOpen = false" />

        <transition enter-active-class="transition duration-150 ease-out transform" enter-from-class="scale-95 opacity-0"
          enter-to-class="scale-100 opacity-100" leave-active-class="transition duration-150 ease-in transform"
          leave-from-class="scale-100 opacity-100" leave-to-class="scale-95 opacity-0">
          <div v-show="dropdownOpen" class="absolute right-0 z-20 w-48 py-2 mt-2 bg-white rounded-md shadow-xl">
            <router-link :to="{ name: 'Profile-Edit' }" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">Profile</router-link>
            <router-link :to="{ name: 'Settings-Edit' }" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">Settings</router-link>
            <a @click="authStore.logout()" class="cursor-pointer block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">
              Log out
            </a>
          </div>
        </transition>
      </div>
    </div>
  </header>
</template>
