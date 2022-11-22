<script setup>

const props = defineProps({
    icon: Function,
    color: {
        type: String,
        default: 'primary'
    },
})

const colors = {
    primary: 'disabled:cursor-not-allowed bg-blue-400 enabled:bg-blue-600 enabled:hover:bg-blue-700 enabled:active:bg-blue-800 text-white',
    secondary: 'disabled:cursor-not-allowed bg-purple-400 enabled:bg-purple-600 enabled:hover:bg-purple-700 enabled:active:bg-purple-800 text-white',
    success: 'disabled:cursor-not-allowed bg-green-300 enabled:bg-green-500 enabled:hover:bg-green-600 enabled:active:bg-green-700 text-white',
    danger: 'disabled:cursor-not-allowed bg-red-400 enabled:bg-red-600 enabled:hover:bg-red-700 enabled:active:bg-red-800 text-white',
    warning: 'disabled:cursor-not-allowed bg-yellow-300 enabled:bg-yellow-500 enabled:hover:bg-yellow-600 enabled:active:bg-yellow-700 text-white',
    info: 'disabled:cursor-not-allowed bg-blue-300 enabled:bg-blue-500 enabled:hover:bg-blue-600 enabled:active:bg-blue-700 text-white',
    dark: 'disabled:cursor-not-allowed bg-gray-500 enabled:bg-gray-700 enabled:hover:bg-gray-800 enabled:active:bg-gray-900 text-white',
}[props.color]

</script>

<template>
    <button type="button"
        class="px-4 py-2 font-medium text-xs leading-normal uppercase rounded shadow-md hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg transition duration-150 ease-in-out flex align-center"
        :class="colors">
        <component :is="icon" class="h-4 w-4 mr-2" />
        <slot />
    </button>
</template>