<script setup>
import { Layout } from '@/Layouts'
import { Button, Pagination, Modal } from '@/Components'
import { Table, Th, Td } from '@/Components/Tables'
import { Input, Select } from '@/Components/Form'
import { ArrowDownTrayIcon, FolderArrowDownIcon, DocumentTextIcon } from '@heroicons/vue/24/outline';
import { useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

const props = defineProps({
    staff: {
        type: Object,
        default: () => ({})
    },
    cari: String,
    unit: {
        type: Array,
        default: () => []
    }
})

const formCari = useForm({
    cari: props.cari
})

const unitExport = ref(null)


function cari() {
    formCari.get(route('rekap.staff'))
}

function exportZip() {
    location.href = route('rekap.staffExportZip', unitExport.value)
}

</script>

<template>
    <Layout judul="Rekap Karyawan">
        <div class="flex justify-between space-x-2">
            <form class="flex space-x-2" @submit.prevent="cari">
                <Input v-model="formCari.cari" placeholder="cari nama / nik" />
                <Button type="submit">Cari</Button>
            </form>
            <Button color="secondary" :icon="ArrowDownTrayIcon" data-bs-toggle="modal"
                data-bs-target="#export">Export</Button>
        </div>

        <Table :items="staff.data" class="mt-4">
            <template #head>
                <Th>No</Th>
                <Th>NIK</Th>
                <Th>Nama</Th>
                <Th>Unit</Th>
                <Th>Preview</Th>
                <Th>Export</Th>
            </template>
            <template #body="{ item, key }">
                <Th>{{ key + staff.from }}</Th>
                <Td :text="item.nik" />
                <Td :text="item.nama" />
                <Td :text="item.unit.unit" />
                <Td>
                    <DocumentTextIcon class="h-6 w-6 text-purple-600 clickable"
                        @click="$inertia.get(route('rekap.staffPreview', item.id))" />
                </Td>
                <Td>
                    <a :href="route('rekap.staffExport', item.id)">
                        <FolderArrowDownIcon class="h-6 w-6 text-green-600" />
                    </a>
                </Td>
            </template>
        </Table>

        <div class="space-y-4 md:space-y-0 md:flex md:justify-between items-center mt-4">
            <div class="text-slate-700">
                Menampilkan <b>{{ staff.from }}</b> sampai <b>{{ staff.to }}</b> dari <b>{{ staff.total }}</b>
            </div>
            <Pagination :links="staff.links" />
        </div>

        <!-- Modal -->
        <Modal title="Export per unit" id="export">
            <Select v-model="unitExport">
                <option v-for="item in unit" :value="item.id">{{ item.unit }}</option>
            </Select>
            <template #footer>
                <Button color="success" @click="exportZip" :disabled="!unitExport">Export</Button>
            </template>
        </Modal>
    </Layout>
</template>