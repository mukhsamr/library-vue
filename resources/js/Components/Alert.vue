<script setup>

const props = defineProps({
    color: {
        type: String,
        default: 'primary'
    },
    text: String
})

const colors = {
    primary: 'bg-blue-100 text-blue-700',
    secondary: 'bg-purple-100 text-purple-700',
    success: 'bg-green-100 text-green-700',
    danger: 'bg-green-100 text-green-700',
    warning: 'bg-yellow-100 text-yellow-700',
    info: 'bg-indigo-100 text-indigo-700',
    dark: 'bg-gray-300 text-gray-800',
}[props.color]

</script>

<template>
    <div class="bg-blue-100 rounded-lg py-5 px-6 mb-4 text-base text-blue-700" :class="colors" role="alert">
        <slot>
            <span v-html="text" />
        </slot>
    </div>
</template>