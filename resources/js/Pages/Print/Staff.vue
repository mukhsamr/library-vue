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
    staff: {
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
    let staff = props.staff.data.map(v => v.id)

    const checked = e.target.checked

    checked
        ? formCheck.value = [...formCheck.value].concat(staff)
        : formCheck.value = [...formCheck.value].filter(v => !staff.includes(v))
}

watch(filter, debounce((item) => {
    Inertia.get(route('print.staff'), {
        baris: item.jumlahBaris,
        cari: item.cariNama,
    }, {
        preserveState: true,
        replace: true
    })
}, 500))

watch(formCheck, (item) => {
    Inertia.get(route('print.staff'), {
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
    let staff = props.staff.data.map(v => v.id)

    const checked = staff.every((v) => formCheck.value.includes(v))

    document.querySelector('#checkall').checked = checked
})

</script>

<template>
    <Layout judul="Barcode Karyawan">
        <div class="flex space-x-2 md:w-1/2">
            <Select class="w-100" v-model="filter.jumlahBaris">
                <option value="10">10</option>
                <option value="30">30</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </Select>
            <Input placeholder="cari nama / nik" v-model="filter.cariNama" />
        </div>

        <Table class="mt-4" :items="staff.data">
            <template #head>
                <Th>No</Th>
                <Th>NIK</Th>
                <Th>Nama</Th>
                <Th>Unit</Th>
                <Th>
                    <Checkbox @change="checkAll($event)" id="checkall" />
                </Th>
            </template>
            <template #body="{ item, key }">
                <Th>{{ key + staff.from }}</Th>
                <Td :text="item.nik" />
                <Td :text="item.nama" />
                <Td :text="item.unit.unit" />
                <Td>
                    <Checkbox v-model="formCheck" :value="item.id" />
                </Td>
            </template>
        </Table>

        <div class="space-y-4 md:space-y-0 md:flex md:justify-between items-center mt-4">
            <div class="text-slate-700">
                Menampilkan <b>{{ staff.from }}</b> sampai <b>{{ staff.to }}</b> dari <b>{{ staff.total }}</b>
            </div>
            <Pagination :links="staff.links" preserveState />
        </div>

        <hr class="my-4">

        <div>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <div class="flex space-x-2 items-center">
                        <span class="whitespace-nowrap">Jumlah baris per-halaman</span>
                        <Input type="number" class="w-24" v-model="pageBreak" min="1" />
                    </div>

                    <span><b>{{ listBarcode.length }}</b> karyawan dipilih</span>
                </div>

                <Button onclick="window.print()" color="success" :icon="PrinterIcon">Cetak</Button>
            </div>

            <div class="grid grid-cols-4">
                <template v-for="item in listBarcode">
                    <div class="border p-2 text-center">
                        <div class="flex justify-center" v-html="item.barcode" />
                        <div class="text-xs mt-2 whitespace-nowrap">{{ item.nama }}</div>
                    </div>
                </template>
            </div>
        </div>
    </Layout>

    <!-- Print -->
    <div class="hidden print:block">
        <template v-for="(chunk, key) in chunk(listBarcode, 4)">
            <div class="grid grid-cols-4" :class="{ 'break-after-page': !((key + 1) % pageBreak) }">
                <template v-for="item in chunk">
                    <div class="border p-2 text-center">
                        <div class="flex justify-center" v-html="item.barcode" />
                        <div class="text-xs mt-2 whitespace-nowrap">{{ item.nama }}</div>
                    </div>
                </template>
            </div>
        </template>
    </div>

</template>