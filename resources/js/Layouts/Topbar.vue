<script setup>
import { Bars3Icon, ArrowLeftOnRectangleIcon as LogoutIcon, Cog6ToothIcon } from '@heroicons/vue/24/outline'
import { inject } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const emitter = inject('mitt')

function toggleSidebar() {
    emitter.emit('toggleSidebar')
}

function logout() {
    Inertia.get(route('logout'), {}, {
        onBefore: () => confirm('Akhiri sesi ini?')
    })
}

</script>

<template>
    <nav
        class="relative  items-center justify-between py-3 bg-white text-gray-500 hover:text-gray-700 focus:text-gray-700 shadow-md">
        <div class="container-fluid w-full flex flex-wrap items-center justify-between px-6">
            <div>
                <Bars3Icon class="h-7 w-7 clickable md:hidden" @click="toggleSidebar" />
            </div>
            <div>
                <div class="flex space-x-4">
                    <Cog6ToothIcon class="h-7 w-7 clickable" @click="$inertia.get(route('user.index'))" />
                    <LogoutIcon class="h-7 w-7 clickable" @click="logout" />
                </div>
            </div>
        </div>
    </nav>
</template>