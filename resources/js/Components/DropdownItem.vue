<script setup>

defineProps({
    text: String
})

</script>

<template>
    <li>
        <a v-bind="$attrs"
            class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-100 cursor-pointer">
            <slot>{{ text }}</slot>
        </a>
    </li>
</template>

<script>
export default {
    inheritAttrs: false,
}
</script>