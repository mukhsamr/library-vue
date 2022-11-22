<script setup>
import { Layout } from '@/Layouts'
import { Table, Th, Td } from '@/Components/Tables'
import { Select, Input } from '@/Components/Form'
import { Button, Pagination } from '@/Components'
import { PlusIcon, TrashIcon } from '@heroicons/vue/24/outline'
import { useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { useToast } from "@/Composables";


const props = defineProps({
    unit: {
        type: Array,
        default: () => []
    },
    staff: {
        type: Object,
        default: () => ({})
    },
    cari: String,
    keyword: String
})

const formCari = useForm({
    unit: props.cari ?? 0,
    keyword: props.keyword
})


function cari() {
    formCari.get(route('staff.index'), {
        preserveState: true
    })
}

function nonaktif(staff) {
    Inertia.delete(route('staff.nonaktif', staff.id), {
        onBefore: () => confirm(`Nonaktifkan ${staff.nama}`),
        onSuccess: () => useToast()
    })
}

</script>

<template>
    <Layout judul="Daftar Karyawan">
        <div class="grid grid-cols-2 gap-2">
            <form class="flex space-x-2" @submit.prevent="cari">
                <Select v-model="formCari.unit">
                    <option value="0">Semua</option>
                    <option v-for="item in unit" :value="item.id">{{ item.unit }}</option>
                </Select>
                <Input v-model="formCari.keyword" placeholder="cari nama / nik" />
                <Button type="submit">Cari</Button>
            </form>
            <div class="flex space-x-2 justify-end">
                <Button color="success" :icon="PlusIcon" @click="$inertia.get(route('staff.form'))">
                    Tambah Karyawan
                </Button>
                <Button color="danger" :icon="TrashIcon" @click="$inertia.get(route('staff.trash'))">
                    Karyawan Nonaktif
                </Button>
            </div>
        </div>

        <Table class="mt-4" :items="staff.data">
            <template #head>
                <Th>No</Th>
                <Th>Nama</Th>
                <Th>NIS</Th>
                <Th>Kelas</Th>
                <Th>Aksi</Th>
            </template>
            <template #body="{ item, key }">
                <Th>{{ key + staff.from }}</Th>
                <Td :text="item.nama" />
                <Td :text="item.nik" />
                <Td :text="item.unit.unit" />
                <Td class="flex space-x-1">
                    <Button color="warning" @click="$inertia.get(route('staff.form', { nik: item.nik }))">Edit</Button>
                    <Button color="danger" @click="nonaktif(item)">Nonaktifkan</Button>
                </Td>
            </template>
        </Table>

        <div class="space-y-4 md:space-y-0 md:flex md:justify-between items-center mt-4">
            <div class="text-slate-700">
                Menampilkan <b>{{ staff.from }}</b> sampai <b>{{ staff.to }}</b> dari <b>{{ staff.total }}</b>
            </div>
            <Pagination :links="staff.links" />
        </div>
    </Layout>
</template>