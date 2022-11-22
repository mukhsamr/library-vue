<script setup>
import { Layout } from '@/Layouts'
import { Input, Select } from '@/Components/Form'
import { Button } from '@/Components'
import { useForm } from '@inertiajs/inertia-vue3';
import { isEmpty } from "lodash";
import { useToast } from "@/Composables";

const props = defineProps({
    siswaList: {
        type: Array,
        default: () => []
    },
    nis: String,
    siswa: {
        type: Object,
        default: () => ({})
    },
    kelas: Array
})

const formTambah = useForm({
    nama: null,
    nis: null,
    grade_id: null
})

const formEdit = useForm({
    id: props.siswa.id,
    nama: props.siswa.nama,
    nis: props.siswa.nis,
    grade_id: props.siswa.grade_id
})


function tambah() {
    formTambah.post(route('siswa.store'), {
        onSuccess: () => useToast()
    })
}

function edit() {
    formEdit.patch(route('siswa.update'), {
        onSuccess: () => useToast()
    })
}

</script>

<template>
    <Layout judul="Form Siswa">
        <form class="border p-4 mt-4" @submit.prevent="tambah" v-if="isEmpty(siswa)">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <Input v-model="formTambah.nama" required label="Nama" />
                <Input v-model="formTambah.nis" required label="NIS" type="number" />
                <Select v-model="formTambah.grade_id" required label="Kelas">
                    <option v-for="item in kelas" :value="item.id">{{ item.kelas }}</option>
                </Select>
            </div>

            <Button type="submit" class="mt-4" color="success" :disabled="!formTambah.isDirty">Tambah</Button>
        </form>

        <form class="border p-4 mt-4" @submit.prevent="edit" v-else>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <Input v-model="formEdit.nama" required label="Nama" />
                <Input v-model="formEdit.nis" required label="NIS" type="number" />
                <Select v-model="formEdit.grade_id" required label="Kelas">
                    <option v-for="item in kelas" :value="item.id">{{ item.kelas }}</option>
                </Select>
            </div>

            <Button type="submit" class="mt-4" color="warning" :disabled="!formEdit.isDirty">Update</Button>
        </form>
    </Layout>
</template>