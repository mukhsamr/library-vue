<script setup>
import { Layout } from '@/Layouts'
import { Button, Pagination } from '@/Components'
import { Input } from '@/Components/Form'
import { Table, Th, Td } from '@/Components/Tables'
import { useForm } from '@inertiajs/inertia-vue3';
import { ArrowPathIcon, TrashIcon } from '@heroicons/vue/24/outline'
import { Inertia } from '@inertiajs/inertia';
import { useToast } from "@/Composables";

const props = defineProps({
    staff: {
        type: Object,
        default: () => ({})
    },
    cari: String
})

const formCari = useForm({
    cari: props.cari
})


function cari() {
    formCari.get(route('staff.trash'))
}

function pulihkan(item) {
    Inertia.patch(route('staff.restore', item.id), null, {
        onBefore: () => confirm(`Pulihkan karyawan ${item.nama}`),
        onSuccess: () => useToast()
    })
}

function destroy(item) {
    Inertia.delete(route('staff.destroy', item.id), {
        onBefore: () => {
            const rand = _.random(1, 100)
            alert('Menghapus permanen akan menghapus semua riwayat peminjaman karyawan ini')
            const verif = prompt(`Ketik ${rand} untuk konfirmasi`)

            if (verif != rand) {
                alert('Verifikasi gagal')
            }

            return verif == rand
        },
        onSuccess: () => useToast()
    })
}

</script>

<template>
    <Layout judul="Karyawan Nonaktif">
        <form class="flex space-x-2" @submit.prevent="cari">
            <Input v-model="formCari.cari" placeholder="cari nama / nik" />
            <Button type="submit">Cari</Button>
        </form>

        <Table class="mt-4" :items="staff.data">
            <template #head>
                <Th>No</Th>
                <Th>Nama</Th>
                <Th>NIK</Th>
                <Th>Unit</Th>
                <Th>Dinonkatifkan</Th>
                <Th>Aksi</Th>
            </template>
            <template #body="{ item, key }">
                <Th>{{ key + staff.from }}</Th>
                <Td :text="item.nama" />
                <Td :text="item.nik" />
                <Td :text="item.unit.unit" />
                <Td :text="item.dihapus" is-time />
                <Td class="flex space-x-2">
                    <Button color="success" :icon="ArrowPathIcon" @click="pulihkan(item)">
                        Pulihkan
                    </Button>
                    <Button color="danger" :icon="TrashIcon" @click="destroy(item)">
                        Hapus Permanen
                    </Button>
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