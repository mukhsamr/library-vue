<script setup>
import { Layout } from '@/Layouts'
import { Input } from '@/Components/Form'
import { Button } from '@/Components'
import { useForm } from '@inertiajs/inertia-vue3';
import { useToast } from "@/Composables";
import { isEmpty } from "lodash";

const props = defineProps({
    judul: String,
    unit: {
        type: Object,
        default: () => ({})
    }
})

const formTambah = useForm({
    unit: null
})

const formEdit = useForm({
    id: props.unit.id,
    unit: props.unit.unit
})


function store() {
    formTambah.post(route('unit.store'), {
        onSuccess: () => useToast()
    })
}

function update() {
    formEdit.patch(route('unit.update'), {
        onSuccess: () => useToast()
    })
}

</script>

<template>
    <Layout :judul="judul">
        <template v-if="isEmpty(unit)">
            <form @submit.prevent="store" class="flex space-x-2 items-end md:w-1/2">
                <Input v-model="formTambah.unit" required label="Nama Unit" />
                <Button type="submit">Simpan</Button>
            </form>
        </template>
        <template v-else>
            <form @submit.prevent="update" class="flex space-x-2 items-end md:w-1/2">
                <Input v-model="formEdit.unit" required label="Nama Unit" />
                <Button type="submit" color="warning">Update</Button>
            </form>
        </template>
    </Layout>
</template>