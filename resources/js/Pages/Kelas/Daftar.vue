<script setup>
import { Layout } from '@/Layouts'
import { Table, Th, Td } from "@/Components/Tables";
import { Button } from "@/Components";
import { PlusIcon, TrashIcon } from '@heroicons/vue/24/outline';
import { Inertia } from '@inertiajs/inertia';
import { useToast } from "@/Composables";


const props = defineProps({
    kelas: {
        type: Array,
        default: () => []
    }
})


function hapus(item) {
    Inertia.delete(route('kelas.hapus', item.id), {
        onBefore: () => confirm(`Hapus kelas ${item.kelas}`),
        onSuccess: () => useToast()
    })
}

</script>

<template>
    <Layout judul="Daftar Kelas">
        <div class="flex mt-4 mb-2 space-x-2 justify-end">
            <Button color="success" :icon="PlusIcon" @click="$inertia.get(route('kelas.tambah'))">Tambah Kelas</Button>
            <Button color="danger" :icon="TrashIcon" @click="$inertia.get(route('kelas.trash'))">Kelas Dihapus</Button>
        </div>
        <Table :items="kelas">
            <template #head>
                <Th>No</Th>
                <Th>Kelas</Th>
                <Th>Jumlah Siswa</Th>
                <Th>Aksi</Th>
            </template>
            <template #body="{ item, key }">
                <Th>{{ key + 1 }}</Th>
                <Td :text="item.kelas" />
                <Td :text="item.students_count" />
                <Td>
                    <div class="flex space-x-2">
                        <Button color="warning" @click="$inertia.get(route('kelas.edit', item.id))">Edit</Button>
                        <Button color="danger" @click="hapus(item)">Hapus</Button>
                        <Button color="info" @click="$inertia.get(route('kelas.list', item.id))">List Siswa</Button>
                    </div>
                </Td>
            </template>
        </Table>
    </Layout>
</template>