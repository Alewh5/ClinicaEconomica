<script setup lang="ts">
import Sidebar from './Sidebar.vue'
import Header from './Header.vue'
</script>

<template>
  <div class="flex h-screen bg-gray-200">
    <Sidebar class="print:hidden" />

    <div class="flex-1 flex flex-col overflow-hidden">
      <Header class="print:hidden" />

      <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
        <div class="container mx-auto px-6 py-6">
          <slot />
        </div>
      </main>
    </div>
  </div>
</template>
