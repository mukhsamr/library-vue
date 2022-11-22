<script setup>
import { isEmpty } from "lodash";

defineProps({
    items: {
        type: Array,
        default: () => []
    }
})

</script>

<template>
    <div class="w-full shadow-md overflow-auto border">
        <table class="border w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <slot name="head" />
                </tr>
            </thead>
            <tbody>
                <template v-if="!isEmpty(items)">
                    <template v-for="(item, key) in items">
                        <tr class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100">
                            <slot name="body" :item="item" :key="key" />
                        </tr>
                    </template>
                </template>
                <tr v-else>
                    <td colspan="100%"
                        class="px-6 py-4 whitespace-nowrap font-medium text-slate-300 italic text-center">
                        Tidak ada data ...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>