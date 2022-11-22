<script setup>
import { Layout } from '@/Layouts';
import { Table, Th, Td } from '@/Components/Tables';
import { BookOpenIcon, UserIcon } from '@heroicons/vue/24/outline';
import { UserIcon as UserIconSolid } from '@heroicons/vue/24/solid';

const props = defineProps({
    jumlahBuku: Number,
    jumlahSiswa: Number,
    jumlahKaryawan: Number,

    bukuDipinjam: {
        type: Array,
        default: () => []
    },
    peminjamTerbanyak: {
        type: Array,
        default: () => []
    },
})

</script>

<template>
    <Layout judul="Beranda">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="border p-3 shadow-md flex space-x-8">
                <BookOpenIcon class="h-14 w-14 ml-4 text-blue-600" />
                <div>
                    <div class="font-semibold text-slate-500">Jumlah Buku</div>
                    <div class="text-2xl font-semibold">{{ jumlahBuku.toLocaleString('id') }}</div>
                </div>
            </div>
            <div class="border p-3 shadow-md flex space-x-8">
                <UserIcon class="h-14 w-14 ml-4 text-blue-600" />
                <div>
                    <div class="font-semibold text-slate-500">Jumlah Siswa</div>
                    <div class="text-2xl font-semibold">{{ jumlahSiswa.toLocaleString('id') }}</div>
                </div>
            </div>
            <div class="border p-3 shadow-md flex space-x-8">
                <UserIconSolid class="h-14 w-14 ml-4 text-blue-600" />
                <div>
                    <div class="font-semibold text-slate-500">Jumlah Karyawan</div>
                    <div class="text-2xl font-semibold">{{ jumlahKaryawan.toLocaleString('id') }}</div>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <h2 class="font-semibold mb-1">Buku terakhir dipinjam</h2>
                <Table :items="bukuDipinjam">
                    <template #head>
                        <Th>Judul Buku</Th>
                        <Th>Peminjam</Th>
                    </template>
                    <template #body="{ item }">
                        <Td :text="item.book.judul" short />
                        <Td :text="item.loanable.nama" />
                    </template>
                </Table>
            </div>
            <div>
                <h2 class="font-semibold mb-1">Peminjam terbanyak bulan ini</h2>
                <Table :items="peminjamTerbanyak">
                    <template #head>
                        <Th>No</Th>
                        <Th>Nama</Th>
                        <Th>Total</Th>
                    </template>
                    <template #body="{ item, key }">
                        <Th>{{ key + 1 }}</Th>
                        <Td :text="item.loanable.nama" />
                        <Td :text="item.total" />
                    </template>
                </Table>
            </div>
        </div>
    </Layout>

</template>