<script setup>
import { Layout } from '@/Layouts'
import { Table, Th, Td } from "@/Components/Tables";
import { Pagination } from "@/Components";
import { isEmpty } from "lodash";

const props = defineProps({
    nama: String,
    riwayat: {
        type: Object,
        default: () => ({})
    }
})

</script>

<template>
    <Layout :judul="'Rekap ' + nama">
        <Table :items="riwayat.data">
            <template #head>
                <Th>No</Th>
                <Th>Dari</Th>
                <Th>Sampai</Th>
                <Th>Judul Buku</Th>
                <Th>Pengarang</Th>
            </template>
            <template #body="{ item, key }">
                <Th>{{ key + riwayat.from }}</Th>
                <Td :text="item.dipinjam" is-date />
                <Td :text="item.dikembalikan" is-date />
                <Td :text="item.book.judul" />
                <Td :text="item.book.pengarang" />
            </template>
        </Table>

        <div class="space-y-4 md:space-y-0 md:flex md:justify-between items-center mt-4" v-if="!isEmpty(riwayat.data)">
            <div class="text-slate-700">
                Menampilkan <b>{{ riwayat.from }}</b> sampai <b>{{ riwayat.to }}</b> dari <b>{{ riwayat.total }}</b>
            </div>
            <Pagination :links="riwayat.links" />
        </div>

    </Layout>
</template>