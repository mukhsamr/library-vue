<script setup>
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    links: Array,
    preserveState: Boolean,
})

</script>

<template>
    <div v-if="links.length > 3">
        <div class="flex flex-nowrap justify-center md:justify-start overflow-auto">
            <template v-for="link in links">
                <div v-if="link.url === null"
                    class="px-3 py-2.5 md:px-4 md:py-3 text-sm leading-3 text-gray-400 border rounded-sm"
                    v-html="link.label" />
                <Link v-else
                    class="px-3 py-2.5 md:px-4 md:py-3 text-sm leading-3 border rounded-sm hover:bg-blue-400 hover:text-white"
                    :class="{ 'bg-blue-500 text-white': link.active }" :href="link.url" preserve-scroll
                    v-html="link.label" :preserve-state="preserveState" />
            </template>
        </div>
    </div>
</template>