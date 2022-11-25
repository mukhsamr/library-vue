<script setup>
import { Layout } from '@/Layouts'
import { Input } from '@/Components/Form'
import { Button } from '@/Components'
import { useForm } from '@inertiajs/inertia-vue3';
import { useToast, useList } from "@/Composables";
import { isEmpty } from "lodash";


const props = defineProps({
    judul: String,
    kelas: {
        type: Object,
        default: () => ({})
    }
})

const formTambah = useForm({
    kelas: null
})

const formEdit = useForm({
    id: props.kelas.id,
    kelas: props.kelas.kelas
})


function store() {
    formTambah.post(route('kelas.store'), {
        onSuccess: () => useToast(),
        onError: (errors) => {
            useToast({
                icon: 'warning',
                title: useList(errors)
            })
        }
    })
}

function update() {
    formEdit.patch(route('kelas.update'), {
        onSuccess: () => useToast(),
        onError: (errors) => {
            useToast({
                icon: 'warning',
                title: useList(errors)
            })
        }
    })
}

</script>

<template>
    <Layout :judul="judul">
        <template v-if="isEmpty(kelas)">
            <form @submit.prevent="store" class="flex space-x-2 items-end md:w-1/2">
                <Input v-model="formTambah.kelas" required label="Nama Kelas" />
                <Button type="submit">Simpan</Button>
            </form>
        </template>
        <template v-else>
            <form @submit.prevent="update" class="flex space-x-2 items-end md:w-1/2">
                <Input v-model="formEdit.kelas" required label="Nama Kelas" />
                <Button type="submit" color="warning">Update</Button>
            </form>
        </template>
    </Layout>
</template>