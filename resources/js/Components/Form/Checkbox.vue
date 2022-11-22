<script setup>
import { onMounted, onUpdated, ref } from 'vue';

const props = defineProps({
    modelValue: Array,
    id: String
})

defineEmits(['update:modelValue'])


// Data
const checkbox = ref()
const isCheck = ref(false)

const id = props.id ?? _.uniqueId('chexbox_')

// Methods
function change(target) {
    if (props.modelValue) {

        const value = parseInt(target.value)
            ? parseInt(target.value)
            : target.value

        if (target.checked) {
            return [...props.modelValue, value]
        } else {
            return props.modelValue.filter(val => val !== value)
        }
    }
}

function mark() {
    if (props.modelValue) {
        const value = parseInt(checkbox.value.value)
            ? parseInt(checkbox.value.value)
            : checkbox.value.value

        isCheck.value = props.modelValue.includes(value)
    }
}


// Mount
onMounted(() => mark())

// Updated
onUpdated(() => mark())
</script>

<template>
    <label :for="id">
        <input :id="id" type="checkbox" class="cursor-pointer" ref="checkbox" :checked="isCheck"
            @change="$emit('update:modelValue', change($event.target))" v-bind="$attrs" />
        <slot />
    </label>
</template>

<script>
export default {
    inheritAttrs: false,
}
</script>
    