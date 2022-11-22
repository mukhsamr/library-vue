<script setup>
import { Layout } from '@/Layouts'
import { Table, Th, Td } from '@/Components/Tables'
import { Button } from '@/Components'
import { ArrowPathIcon, TrashIcon } from '@heroicons/vue/24/outline'
import { Inertia } from '@inertiajs/inertia';
import { useToast } from "@/Composables";

const props = defineProps({
    kelas: {
        type: Array,
        default: () => []
    }
})


function restore(item) {
    Inertia.patch(route('kelas.restore', item.id), null, {
        onBefore: () => confirm(`Pulihkan kelas ${item.kelas}`),
        onSuccess: () => useToast()
    })
}

function destroy(item) {
    Inertia.delete(route('kelas.destroy', item.id), {
        onBefore: () => {
            let verif = prompt(`Ketik ${item.kelas} untuk konfirmasi`)

            if (verif != item.kelas) {
                alert('Verifikasi gagal')
            }

            return verif == item.kelas
        },
        onSuccess: () => useToast()
    })
}

</script>

<template>
    <Layout judul="Kelas Dihapus">
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
                <Td class="flex space-x-2">
                    <Button color="success" :icon="ArrowPathIcon" @click="restore(item)">Pulihkan</Button>
                    <Button color="danger" :icon="TrashIcon" :disabled="item.students_count"
                        @click="destroy(item)">Hapus Permanen</Button>
                </Td>
            </template>
        </Table>
    </Layout>
</template>