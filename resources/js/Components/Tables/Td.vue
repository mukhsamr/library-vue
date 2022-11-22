<script setup>
import { ref } from 'vue';


defineProps({
    text: String | Number,
    isTime: Boolean,
    isDate: Boolean,
    short: Boolean
})

const style = 'px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900'
const shortHide = ref(true)

</script>

<template>
    <td :class="style" class="relative" v-if="isTime">
        <span class="peer cursor-pointer select-none">{{ text.content ?? '-' }}</span>
        <span
            class="absolute left-0 -bottom-4 p-2 bg-slate-800 text-white text-xs rounded-sm italic hidden peer-active:inline">
            {{ text.tooltips }}
        </span>
    </td>
    <td :class="style" v-else-if="isDate">
        <span>{{ new Date(text).toLocaleString('id-ID', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            })
        }}</span>
    </td>
    <td :class="style" v-else-if="short">
        <template v-if="text.length > 40">
            <span :class="{ 'hidden': !shortHide }">
                {{ text.substring(0, 40) }} <span class="text-blue-400 cursor-pointer"
                    @click="shortHide = !shortHide">(...)</span>
            </span>
            <span :class="{ 'hidden': shortHide }">{{ text }}</span>
        </template>
        <span v-else>{{ text }}</span>
    </td>
    <td :class="style" v-else>
        <slot>{{ text ?? '-' }}</slot>
    </td>
</template>