<script setup>

const props = defineProps({
    id: String,
    modelValue: File,
    label: String | Boolean,
    required: Boolean,
    invalid: String
})

const uid = props.id ?? 'file-input-' + _.random(1, 100)
const redTick = "after:content-['*'] after:ml-0.5 after:text-red-500"

defineEmits(['update:modelValue'])

</script>

<template>
    <div class="w-full">
        <template v-if="label">
            <label :for="uid" class="form-label inline-block mb-2 text-gray-700">
                <span :class="{ [redTick]: required }">
                    <slot>{{ label }}</slot>
                </span>
            </label>
        </template>
        <input type="file"
            class="form-control block w-full px-3 py-1 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-200 focus:outline-none"
            :id="uid" v-bind="$attrs" @input="$emit('update:modelValue', $event.target.files[0])"
            :required="required" />
        <div class="text-red-500" v-if="invalid">{{ invalid }}</div>
    </div>
</template>

<script>
export default {
    inheritAttrs: false,
}
</script>