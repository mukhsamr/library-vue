<script setup>
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    links: Array
})

const items = props.links

const item = items.splice(1, items.length - 2)

const index = item.findIndex(e => e.active)
const start = index - 2 < 1 ? 0 : index - 2
const last = item.length > index + 3 ? index + 3 : item.length
const slice = item.slice(start, last)

items.splice(1, 0, ...slice)

</script>

<template>
    <div v-if="items.length > 3">
        <div class="flex flex-nowrap justify-center md:justify-start">
            <template v-for="link in items">
                <div v-if="link.url === null"
                    class="px-3 py-2.5 md:px-4 md:py-3 text-sm leading-3 text-gray-400 border rounded-sm"
                    v-html="link.label" />
                <Link v-else
                    class="px-3 py-2.5 md:px-4 md:py-3 text-sm leading-3 border rounded-sm hover:bg-blue-400 hover:text-white"
                    :class="{ 'bg-blue-500 text-white': link.active }" :href="link.url" v-html="link.label" />
            </template>
        </div>
    </div>
</template>