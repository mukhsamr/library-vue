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
    kelas: {
        type: Array,
        default: () => []
    },
    siswa: {
        type: Object,
        default: () => ({})
    },
    cari: String,
    keyword: String
})

const formCari = useForm({
    kelas: props.cari ?? 0,
    keyword: props.keyword
})


function cari() {
    formCari.get(route('siswa.index'), {
        preserveState: true
    })
}

function nonaktif(siswa) {
    Inertia.delete(route('siswa.nonaktif', siswa.id), {
        onBefore: () => confirm(`Nonaktifkan ${siswa.nama}`),
        onSuccess: () => useToast()
    })
}

</script>

<template>
    <Layout judul="Daftar Siswa">
        <div class="grid grid-cols-2 gap-2">
            <form class="flex space-x-2" @submit.prevent="cari">
                <Select v-model="formCari.kelas">
                    <option value="0">Semua</option>
                    <option v-for="item in kelas" :value="item.id">{{ item.kelas }}</option>
                </Select>
                <Input v-model="formCari.keyword" placeholder="cari nama / nis" />
                <Button type="submit">Cari</Button>
            </form>
            <div class="flex space-x-2 justify-end">
                <Button color="success" :icon="PlusIcon" @click="$inertia.get(route('siswa.form'))">
                    Tambah Siswa
                </Button>
                <Button color="danger" :icon="TrashIcon" @click="$inertia.get(route('siswa.trash'))">
                    Siswa Nonaktif
                </Button>
            </div>
        </div>

        <Table class="mt-4" :items="siswa.data">
            <template #head>
                <Th>No</Th>
                <Th>Nama</Th>
                <Th>NIS</Th>
                <Th>Kelas</Th>
                <Th>Aksi</Th>
            </template>
            <template #body="{ item, key }">
                <Th>{{ key + siswa.from }}</Th>
                <Td :text="item.nama" />
                <Td :text="item.nis" />
                <Td :text="item.grade.kelas" />
                <Td class="flex space-x-1">
                    <Button color="warning" @click="$inertia.get(route('siswa.form', { nis: item.nis }))">Edit</Button>
                    <Button color="danger" @click="nonaktif(item)">Nonaktifkan</Button>
                </Td>
            </template>
        </Table>

        <div class="space-y-4 md:space-y-0 md:flex md:justify-between items-center mt-4">
            <div class="text-slate-700">
                Menampilkan <b>{{ siswa.from }}</b> sampai <b>{{ siswa.to }}</b> dari <b>{{ siswa.total }}</b>
            </div>
            <Pagination :links="siswa.links" />
        </div>
    </Layout>
</template>