<script setup>
import { Layout } from '@/Layouts'
import { Table, Th, Td } from "@/Components/Tables";
import { Button } from "@/Components";
import { PlusIcon, TrashIcon } from '@heroicons/vue/24/outline';
import { Inertia } from '@inertiajs/inertia';
import { useToast } from "@/Composables";


const props = defineProps({
    unit: {
        type: Array,
        default: () => []
    }
})


function hapus(item) {
    Inertia.delete(route('unit.hapus', item.id), {
        onBefore: () => confirm(`Hapus unit ${item.unit}`),
        onSuccess: () => useToast()
    })
}

</script>

<template>
    <Layout judul="Daftar Unit">
        <div class="flex mt-4 mb-2 space-x-2 justify-end">
            <Button color="success" :icon="PlusIcon" @click="$inertia.get(route('unit.tambah'))">Tambah Unit</Button>
            <Button color="danger" :icon="TrashIcon" @click="$inertia.get(route('unit.trash'))">Unit Dihapus</Button>
        </div>
        <Table :items="unit">
            <template #head>
                <Th>No</Th>
                <Th>Unit</Th>
                <Th>Jumlah Karyawan</Th>
                <Th>Aksi</Th>
            </template>
            <template #body="{ item, key }">
                <Th>{{ key + 1 }}</Th>
                <Td :text="item.unit" />
                <Td :text="item.staff_count" />
                <Td>
                    <div class="flex space-x-2">
                        <Button color="warning" @click="$inertia.get(route('unit.edit', item.id))">Edit</Button>
                        <Button color="danger" @click="hapus(item)">Hapus</Button>
                        <Button color="info" @click="$inertia.get(route('unit.list', item.id))">List Karyawan</Button>
                    </div>
                </Td>
            </template>
        </Table>
    </Layout>
</template>