<script setup>
import { Layout } from '@/Layouts'
import { Table, Th, Td } from '@/Components/Tables'
import { Button } from '@/Components'
import { ArrowPathIcon, TrashIcon } from '@heroicons/vue/24/outline'
import { Inertia } from '@inertiajs/inertia';
import { useToast } from "@/Composables";

const props = defineProps({
    unit: {
        type: Array,
        default: () => []
    }
})


function restore(item) {
    Inertia.patch(route('unit.restore', item.id), null, {
        onBefore: () => confirm(`Pulihkan unit ${item.unit}`),
        onSuccess: () => useToast()
    })
}

function destroy(item) {
    Inertia.delete(route('unit.destroy', item.id), {
        onBefore: () => {
            let verif = prompt(`Ketik ${item.unit} untuk konfirmasi`)

            if (verif != item.unit) {
                alert('Verifikasi gagal')
            }

            return verif == item.unit
        },
        onSuccess: () => useToast()
    })
}

</script>

<template>
    <Layout judul="Unit Dihapus">
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
                <Td class="flex space-x-2">
                    <Button color="success" :icon="ArrowPathIcon" @click="restore(item)">Pulihkan</Button>
                    <Button color="danger" :icon="TrashIcon" :disabled="item.staff_count" @click="destroy(item)">Hapus
                        Permanen</Button>
                </Td>
            </template>
        </Table>
    </Layout>
</template>