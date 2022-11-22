<script setup>
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    text: {
        type: String,
        required: true
    },
    icon: Function,
    active: String
})

</script>


<template>
    <Link
        class="flex items-center text-sm py-4 px-6 h-12 overflow-hidden text-gray-700 text-ellipsis whitespace-nowrap rounded hover:text-blue-600 hover:font-semibold hover:bg-blue-50 transition duration-300 ease-in-out"
        :class="{ 'text-blue-600 bg-blue-100 font-semibold': $page.url.startsWith(active) }" data-mdb-ripple="true"
        data-mdb-ripple-color="primary">
    <component :is="icon" class="h-5 w-5 mr-4" v-if="icon" />
    <span>
        <slot>
            {{ text }}
        </slot>
    </span>
    </Link>
</template>