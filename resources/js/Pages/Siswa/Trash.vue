<script setup>
import { Layout } from '@/Layouts'
import { Button, Pagination } from '@/Components'
import { Input } from '@/Components/Form'
import { Table, Th, Td } from '@/Components/Tables'
import { useForm } from '@inertiajs/inertia-vue3';
import { ArrowPathIcon } from '@heroicons/vue/24/outline'
import { Inertia } from '@inertiajs/inertia';
import { useToast } from "@/Composables";

const props = defineProps({
    siswa: {
        type: Object,
        default: () => ({})
    },
    cari: String
})

const formCari = useForm({
    cari: props.cari
})


function cari() {
    formCari.get(route('siswa.trash'))
}

function pulihkan(item) {
    Inertia.patch(route('siswa.restore', item.id), null, {
        onBefore: () => confirm(`Pulihkan siswa ${item.nama}`),
        onSuccess: () => useToast()
    })
}

</script>

<template>
    <Layout judul="Siswa Nonaktif">
        <form class="flex space-x-2" @submit.prevent="cari">
            <Input v-model="formCari.cari" placeholder="cari nama / nis" />
            <Button type="submit">Cari</Button>
        </form>

        <Table class="mt-4" :items="siswa.data">
            <template #head>
                <Th>No</Th>
                <Th>Nama</Th>
                <Th>NIS</Th>
                <Th>Kelas</Th>
                <Th>Dihapus</Th>
                <Th>Pulihkan</Th>
            </template>
            <template #body="{ item, key }">
                <Th>{{ key + siswa.from }}</Th>
                <Td :text="item.nama" />
                <Td :text="item.nis" />
                <Td :text="item.grade.kelas" />
                <Td :text="item.dihapus" is-time />
                <Td>
                    <Button color="success" :icon="ArrowPathIcon" @click="pulihkan(item)">
                        Pulihkan
                    </Button>
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