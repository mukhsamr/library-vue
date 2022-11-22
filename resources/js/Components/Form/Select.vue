<script setup>

const props = defineProps({
    modelValue: String | Number,
    id: String,
    label: String,
    required: Boolean
})

const id = _.uniqueId('select_')
const redTick = "after:content-['*'] after:ml-0.5 after:text-red-500"

defineEmits(['update:modelValue'])

</script>

<template>
    <div class="w-full">
        <template v-if="label">
            <label :for="id" class="form-label inline-block mb-1 text-gray-700">
                <span :class="{ [redTick]: required }">
                    {{ label }}
                </span>
            </label>
        </template>
        <select
            class="form-select appearance-none block w-full px-3 py-1 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-200 focus:outline-none"
            v-bind="$attrs" :id="id" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)">
            <slot />
        </select>
    </div>
</template>