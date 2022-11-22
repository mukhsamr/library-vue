<script setup>

defineProps({
    kolom: String,
    text: String | Number
})

</script>

<template>
    <li class="even:bg-white odd:bg-slate-100 py-1.5 px-3">
        <div class="grid grid-cols-1 md:grid-cols-8">
            <div class="md:col-span-2">
                <b class="md:text-base">{{ kolom }}</b>
            </div>
            <div class="md:col-span-6">
                <p>
                    <slot>{{ text ?? '-' }}</slot>
                </p>
            </div>
        </div>
    </li>
</template>