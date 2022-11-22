<script setup>

import { Layout } from '@/Layouts';
import { Select, Input } from '@/Components/Form';
import { Button, Pagination } from '@/Components';
import { Table, Th, Td } from '@/Components/Tables';
import { useForm } from '@inertiajs/inertia-vue3';
import { TrashIcon } from '@heroicons/vue/24/outline'
import { ref } from 'vue';


const props = defineProps({
    kolom: Object,
    buku: {
        type: Object,
        default: () => ({})
    },
    kategori: String,
    keyword: String
})

const formCari = useForm({
    kategori: props.kategori,
    keyword: props.keyword
})


function cari() {
    formCari.get(route('buku.daftar'), {
        preserveState: true
    })
}


</script>

<template>

    <Layout judul="Daftar Buku">
        <form class="flex space-x-2 md:space-x-3 items-center md:w-1/2 mb-4" @submit.prevent="cari">
            <Select v-model="formCari.kategori">
                <option v-for="(item, key) in kolom" :value="key">{{ item }}</option>
            </Select>
            <Input v-model="formCari.keyword" placeholder="kata kunci ..." autofocus />
            <Button type="submit" :disabled="formCari.processing">Cari</Button>
        </form>

        <Table :items="buku.data">
            <template #head>
                <Th>No</Th>
                <Th>Tanggal</Th>
                <Th>NIK</Th>
                <Th>Judul</Th>
                <Th>Pengarang</Th>
                <Th>Kota Penerbit</Th>
                <Th>Penerbit</Th>
                <Th>Edisi</Th>
                <Th>Tahun Terbit</Th>
                <Th>ISBN</Th>
                <Th>Sumber</Th>
                <Th>Klasifikasi</Th>
                <Th>Lokasi Penyimpanan</Th>
                <Th>Jenis Buku</Th>
                <Th>Jumlah Halaman</Th>
                <Th>Eksemplar</Th>
                <Th>Keterangan</Th>
                <Th>Tanggal diinput</Th>
                <Th>Terakhir diedit</Th>
            </template>
            <template #body="{ item, key }">
                <Th>{{ key + buku.from }}</Th>
                <Td :text="item.tanggal" />
                <Td :text="item.nik" />
                <Td :text="item.judul" short />
                <Td :text="item.pengarang" />
                <Td :text="item.kota_penerbit" />
                <Td :text="item.penerbit" />
                <Td :text="item.edisi_cetakan" />
                <Td :text="item.tahun_terbit" />
                <Td :text="item.isbn" />
                <Td :text="item.sumber" />
                <Td :text="item.klasifikasi" />
                <Td :text="item.lokasi_penyimpanan" />
                <Td :text="item.jenis" />
                <Td :text="item.jumlah_halaman" />
                <Td :text="item.jumlah_buku" />
                <Td :text="item.deskripsi" />
                <Td :text="item.dibuat" is-time />
                <Td :text="item.diedit" is-time />
            </template>
        </Table>
        <div class="space-y-4 md:space-y-0 md:flex md:justify-between items-center mt-4">
            <div class="text-slate-700">
                Menampilkan <b>{{ buku.from }}</b> sampai <b>{{ buku.to }}</b> dari <b>{{ buku.total }}</b>
            </div>
            <Pagination :links="buku.links" preserveState />
        </div>
    </Layout>

</template>