<script setup>

const props = defineProps({
    id: String,
    modelValue: String | Number,
    label: String | Boolean,
    required: Boolean,
    invalid: String
})

const uid = props.id ?? _.uniqueId('input_')
const redTick = "after:content-['*'] after:ml-0.5 after:text-red-500"

defineEmits(['update:modelValue'])

</script>

<template>
    <div class="w-full">
        <template v-if="label">
            <label :for="uid" class="form-label inline-block mb-1 text-gray-700">
                <span :class="{ [redTick]: required }">
                    <slot>{{ label }}</slot>
                </span>
            </label>
        </template>
        <input type="text"
            class="form-control block w-full px-3 py-1 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-200 focus:outline-none read-only:bg-slate-100"
            :class="{ 'border-red-500': invalid }" :id="uid" :value="modelValue" v-bind="$attrs"
            @input="$emit('update:modelValue', $event.target.value)" :required="required" />
        <div class="text-red-500" v-if="invalid">{{ invalid }}</div>
    </div>
</template>

<script>
export default {
    inheritAttrs: false,
}
</script>