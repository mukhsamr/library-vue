<script setup>

const props = defineProps({
    color: {
        type: String,
        default: 'primary'
    }
})

const colors = {
    primary: 'bg-blue-600',
    secondary: 'bg-purple-600',
    success: 'bg-green-600',
    danger: 'bg-red-600',
    warning: 'bg-yellow-500',
    info: 'bg-indigo-600',
    dark: 'bg-gray-600',
}[props.color];

</script>

<template>
    <span class="text-xs inline-block py-1 px-2.5 leading-none text-center whitespace-nowrap text-white rounded-full"
        :class="colors">
        <slot />
    </span>
</template>