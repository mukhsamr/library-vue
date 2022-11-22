<script setup>
import { Layout } from '@/Layouts'
import { Button } from '@/Components'
import { Table, Th, Td } from '@/Components/Tables'
import { ArrowPathIcon, TrashIcon } from '@heroicons/vue/24/outline'
import { Inertia } from '@inertiajs/inertia';
import { useToast } from "@/Composables";

const props = defineProps({
    buku: {
        type: Array,
        default: () => []
    }
})


function restore(item) {
    Inertia.patch(route('form.restore', item.id), null, {
        onBefore: () => confirm(`pulihkan ${item.judul}`),
        onSuccess: () => useToast()
    })
}

function hapus(item) {
    Inertia.delete(route('form.destroy', item.id), {
        onBefore: () => {
            const rand = _.random(1, 100)
            alert('Menghapus permanen akan menghapus semua riwayat peminjaman buku ini')
            const verif = prompt(`Ketik ${rand} untuk konfirmasi`)

            if (verif != rand) {
                alert('Verifikasi gagal')
            }

            return verif == rand
        }
    })
}

</script>

<template>
    <Layout judul="Buku Dihapus">
        <Table :items="buku">
            <template #head>
                <Th>No</Th>
                <Th>NIK</Th>
                <Th>Judul</Th>
                <Th>Catatan</Th>
                <Th>Waktu Dihapus</Th>
                <Th>Aksi</Th>
            </template>
            <template #body="{ item, key }">
                <Th>{{ key + 1 }}</Th>
                <Td :text="item.nik" />
                <Td :text="item.judul" />
                <Td :text="item.catatan" />
                <Td :text="item.dihapus" is-time />
                <Td class="flex space-x-2">
                    <Button color="success" :icon="ArrowPathIcon" @click="restore(item)">Pulihkan</Button>
                    <Button color="danger" :icon="TrashIcon" @click="hapus(item)">Hapus Permanen</Button>
                </Td>
            </template>
        </Table>
    </Layout>
</template>