<script setup>

import { ChevronDownIcon } from '@heroicons/vue/24/outline'
import { onMounted } from 'vue';

const props = defineProps({
    id: {
        type: String,
        required: true,
        default: 'multilink-' + Math.floor(Math.random() * 100)
    },
    text: {
        type: String,
        required: true
    },
    icon: {
        type: Function,
        required: true
    },
    active: String
})


function addStyleLink() {
    const links = document.querySelector(`#collapse${props.id}`).children

    for (const link of links) {
        link.className += 'flex items-center text-sm py-4 pl-12 pr-6 h-6 overflow-hidden text-gray-700 text-ellipsis whitespace-nowrap rounded hover:text-blue-600 hover:bg-blue-50 transition duration-300 ease-in-out'
    }
}

onMounted(() => {
    addStyleLink()
})

</script>

<template>
    <li class="relative" :id="id">
        <a class="flex items-center text-sm py-4 px-6 h-12 overflow-hidden text-gray-700 text-ellipsis whitespace-nowrap rounded hover:text-blue-600 hover:font-semibold hover:bg-blue-50 transition duration-300 ease-in-out cursor-pointer"
            :class="{ 'text-blue-600 bg-blue-100 font-semibold': $page.url.startsWith(active) }" data-mdb-ripple="true"
            data-mdb-ripple-color="primary" data-bs-toggle="collapse" :data-bs-target="'#collapse' + id"
            aria-expanded="false" :aria-controls="'collapse' + id">
            <component :is="icon" class="h-5 w-5 mr-4" />
            <span>{{ text }}</span>
            <ChevronDownIcon class="h-4 w-4 ml-auto" />
        </a>
        <ul class="relative accordion-collapse collapse" :id="'collapse' + id" :aria-labelledby="id"
            data-bs-parent="#sideBar">
            <slot />
        </ul>
    </li>
</template>