<script setup>
import { Layout } from '@/Layouts'
import { Input, Select } from '@/Components/Form'
import { Button } from '@/Components'
import { useForm } from '@inertiajs/inertia-vue3';
import { isEmpty } from "lodash";
import { useToast } from "@/Composables";

const props = defineProps({
    staffList: {
        type: Array,
        default: () => []
    },
    nik: String,
    staff: {
        type: Object,
        default: () => ({})
    },
    unit: Array
})

const formTambah = useForm({
    nama: null,
    nik: null,
    unit_id: null
})

const formEdit = useForm({
    id: props.staff.id,
    nama: props.staff.nama,
    nik: props.staff.nik,
    unit_id: props.staff.unit_id
})


function tambah() {
    formTambah.post(route('staff.store'), {
        onSuccess: () => useToast()
    })
}

function edit() {
    formEdit.patch(route('staff.update'), {
        onSuccess: () => useToast()
    })
}

</script>

<template>
    <Layout judul="Form Karyawan">
        <form class="border p-4 mt-4" @submit.prevent="tambah" v-if="isEmpty(staff)">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <Input v-model="formTambah.nama" required label="Nama" />
                <Input v-model="formTambah.nik" required label="NIK" type="number" />
                <Select v-model="formTambah.unit_id" required label="Kelas">
                    <option v-for="item in unit" :value="item.id">{{ item.unit }}</option>
                </Select>
            </div>

            <Button type="submit" class="mt-4" color="success" :disabled="!formTambah.isDirty">Tambah</Button>
        </form>

        <form class="border p-4 mt-4" @submit.prevent="edit" v-else>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <Input v-model="formEdit.nama" required label="Nama" />
                <Input v-model="formEdit.nik" required label="NIK" type="number" />
                <Select v-model="formEdit.unit_id" required label="Unit">
                    <option v-for="item in unit" :value="item.id">{{ item.unit }}</option>
                </Select>
            </div>

            <Button type="submit" class="mt-4" color="warning" :disabled="!formEdit.isDirty">Update</Button>
        </form>
    </Layout>
</template>