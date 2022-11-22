<script setup>
import { Layout } from '@/Layouts'
import { Pagination, Button } from '@/Components'
import { Select, Input, Checkbox } from '@/Components/Form'
import { Table, Th, Td } from '@/Components/Tables'
import { onUpdated, reactive, ref, watch } from 'vue';
import { Inertia } from "@inertiajs/inertia";
import { chunk, debounce } from "lodash";
import { PrinterIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
    buku: {
        type: Object,
        default: () => ({})
    },
    baris: String | Number,
    cari: String,
    barcode: {
        type: Array,
        default: () => []
    }
})

const filter = reactive({
    jumlahBaris: props.baris,
    cariNama: props.cari
})

const formCheck = ref([])
const listBarcode = ref([])
const pageBreak = ref(8)


function checkAll(e) {
    let buku = props.buku.data.map(v => v.id)

    const checked = e.target.checked

    checked
        ? formCheck.value = [...formCheck.value].concat(buku)
        : formCheck.value = [...formCheck.value].filter(v => !buku.includes(v))
}

watch(filter, debounce((item) => {
    Inertia.get(route('print.buku'), {
        baris: item.jumlahBaris,
        cari: item.cariNama,
    }, {
        preserveState: true,
        replace: true
    })
}, 500))

watch(formCheck, (item) => {
    Inertia.get(route('print.buku'), {
        check: [...item]
    }, {
        only: ['barcode'],
        preserveState: true,
        preserveScroll: true,
        replace: true,
        onSuccess: () => {
            listBarcode.value = props.barcode
        }
    })
})

onUpdated(() => {

    // Cek checkbox all per-halaman
    let buku = props.buku.data.map(v => v.id)

    const checked = buku.every((v) => formCheck.value.includes(v))

    document.querySelector('#checkall').checked = checked
})

</script>

<template>
    <Layout judul="Barcode Buku">
        <div class="flex space-x-2 md:w-1/2">
            <Select class="w-100" v-model="filter.jumlahBaris">
                <option value="10">10</option>
                <option value="30">30</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </Select>
            <Input placeholder="cari nama / nik" v-model="filter.cariNama" />
        </div>

        <Table class="mt-4" :items="buku.data">
            <template #head>
                <Th>No</Th>
                <Th>NIK</Th>
                <Th>Judul</Th>
                <Th>Eksemplar</Th>
                <Th>
                    <Checkbox @change="checkAll($event)" id="checkall" />
                </Th>
            </template>
            <template #body="{ item, key }">
                <Th>{{ key + buku.from }}</Th>
                <Td :text="item.nik" />
                <Td :text="item.judul" short />
                <Td :text="item.jumlah_buku" />
                <Td>
                    <Checkbox v-model="formCheck" :value="item.id" />
                </Td>
            </template>
        </Table>

        <div class="space-y-4 md:space-y-0 md:flex md:justify-between items-center mt-4">
            <div class="text-slate-700">
                Menampilkan <b>{{ buku.from }}</b> sampai <b>{{ buku.to }}</b> dari <b>{{ buku.total }}</b>
            </div>
            <Pagination :links="buku.links" preserveState />
        </div>

        <hr class="my-4">

        <div>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <div class="flex space-x-2 items-center">
                        <span class="whitespace-nowrap">Jumlah baris per-halaman</span>
                        <Input type="number" class="w-24" v-model="pageBreak" min="1" />
                    </div>

                    <span><b>{{ listBarcode.length }}</b> buku dipilih</span>
                </div>

                <Button onclick="window.print()" color="success" :icon="PrinterIcon">Cetak</Button>
            </div>

            <template v-for="(chunk, key) in chunk(listBarcode, 4)">
                <div class="grid grid-flow-col auto-cols-max" :class="{ 'break-after-page': !((key + 1) % pageBreak) }">
                    <template v-for="item in chunk">
                        <div class="border p-2 text-center w-[7cm]">
                            <div class="grid grid-cols-2">
                                <div class="relative my-auto">
                                    <div class="flex relative -left-1/2">
                                        <div class="rotate-90">
                                            <div class="justify-center" v-html="item.barcode" />
                                            <div class="text-sm mt-2 whitespace-nowrap">{{ item.nik }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-2 border-black w-[3cm]">
                                    <div class="border-b-2 border-black h-[1cm]">
                                        <img src="/storage/images/logo.png" class="w-9 m-auto" alt="logo">
                                    </div>
                                    <div class="h-[3.5cm] space-y-1 py-2">
                                        <div>{{ item.klasifikasi ?? '-' }}</div>
                                        <div>{{ item.pengarang_kode ?? '-' }}</div>
                                        <div>{{ item.judul_kode ?? '-' }}</div>
                                        <div>{{ item.copy }}</div>
                                    </div>
                                    <div class="h-[3cm]" :style="`background-color: ${item.jenis_warna}`" />
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </Layout>

    <!-- Print -->
    <div class="hidden print:block">
        <template v-for="(chunk, key) in chunk(listBarcode, 4)">
            <div class="grid grid-flow-col auto-cols-max" :class="{ 'break-after-page': !((key + 1) % pageBreak) }">
                <template v-for="item in chunk">
                    <div class="border p-2 text-center w-[7cm]">
                        <div class="grid grid-cols-2">
                            <div class="relative my-auto">
                                <div class="flex relative -left-1/2">
                                    <div class="rotate-90">
                                        <div class="justify-center" v-html="item.barcode" />
                                        <div class="text-sm mt-2 whitespace-nowrap">{{ item.nik }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="border-2 border-black w-[3cm]">
                                <div class="border-b-2 border-black h-[1cm]">
                                    <img src="/storage/images/logo.png" class="w-9 m-auto" alt="logo">
                                </div>
                                <div class="h-[3.5cm] space-y-1 py-2">
                                    <div>{{ item.klasifikasi ?? '-' }}</div>
                                    <div>{{ item.pengarang_kode ?? '-' }}</div>
                                    <div>{{ item.judul_kode ?? '-' }}</div>
                                    <div>{{ item.copy }}</div>
                                </div>
                                <div class="h-[3cm]" :style="`background-color: ${item.jenis_warna}`" />
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </template>
    </div>

</template>