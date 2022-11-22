<script setup>
import Sidebar from './Sidebar.vue';
import Topbar from './Topbar.vue';

defineProps({
    judul: {
        type: String,
        required: true
    }
})

</script>

<template>
    <main class="flex print:hidden">
        <!-- Sidebar -->
        <Sidebar class="md:translate-x-0" />

        <!-- Container -->
        <div class="w-full md:ml-60 md:w-[calc(100%-15rem)]">
            <Topbar />

            <!-- Content -->
            <div class="w-full p-6">
                <h2 class="text-2xl">{{ judul }}</h2>
                <hr class="my-2">
                <slot />
            </div>

        </div>
    </main>

</template>