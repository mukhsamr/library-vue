<script setup>

defineProps({
    modelValue: Boolean
})

defineEmits(['update:modelValue'])

const id = _.uniqueId('switch_')

</script>

<template>
    <div class="form-check form-switch">
        <input
            class="form-check-input appearance-none w-9 -ml-10 rounded-full float-left h-5 align-top bg-no-repeat bg-contain bg-gray-300 focus:outline-none cursor-pointer shadow-sm"
            type="checkbox" role="switch" :id="id" :checked="modelValue"
            @change="$emit('update:modelValue', $event.target.checked)">
        <label class="form-check-label inline-block text-gray-800 cursor-pointer" :for="id">
            <slot />
        </label>
    </div>
</template>