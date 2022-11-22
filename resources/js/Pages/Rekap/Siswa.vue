<script setup>
import { Layout } from '@/Layouts'
import { Button, Pagination, Modal } from '@/Components'
import { Table, Th, Td } from '@/Components/Tables'
import { Input, Select } from '@/Components/Form'
import { ArrowDownTrayIcon, FolderArrowDownIcon, DocumentTextIcon } from '@heroicons/vue/24/outline';
import { useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

const props = defineProps({
    siswa: {
        type: Object,
        default: () => ({})
    },
    cari: String,
    kelas: {
        type: Array,
        default: () => []
    }
})

const formCari = useForm({
    cari: props.cari
})

const kelasExport = ref(null)


function cari() {
    formCari.get(route('rekap.siswa'))
}

function exportZip() {
    location.href = route('rekap.siswaExportZip', kelasExport.value)
}


</script>

<template>
    <Layout judul="Rekap Siswa">
        <div class="flex justify-between space-x-2">
            <form class="flex space-x-2" @submit.prevent="cari">
                <Input v-model="formCari.cari" placeholder="cari nama / nis" />
                <Button type="submit">Cari</Button>
            </form>
            <Button color="secondary" :icon="ArrowDownTrayIcon" data-bs-toggle="modal"
                data-bs-target="#export">Export</Button>
        </div>

        <Table :items="siswa.data" class="mt-4">
            <template #head>
                <Th>No</Th>
                <Th>NIS</Th>
                <Th>Nama</Th>
                <Th>Kelas</Th>
                <Th>Preview</Th>
                <Th>Export</Th>
            </template>
            <template #body="{ item, key }">
                <Th>{{ key + siswa.from }}</Th>
                <Td :text="item.nis" />
                <Td :text="item.nama" />
                <Td :text="item.grade.kelas" />
                <Td>
                    <DocumentTextIcon class="h-6 w-6 text-purple-600 clickable"
                        @click="$inertia.get(route('rekap.siswaPreview', item.id))" />
                </Td>
                <Td>
                    <a :href="route('rekap.siswaExport', item.id)">
                        <FolderArrowDownIcon class="h-6 w-6 text-green-600" />
                    </a>
                </Td>
            </template>
        </Table>

        <div class="space-y-4 md:space-y-0 md:flex md:justify-between items-center mt-4">
            <div class="text-slate-700">
                Menampilkan <b>{{ siswa.from }}</b> sampai <b>{{ siswa.to }}</b> dari <b>{{ siswa.total }}</b>
            </div>
            <Pagination :links="siswa.links" />
        </div>

        <!-- Modal -->
        <Modal title="Export per kelas" id="export">
            <Select v-model="kelasExport">
                <option v-for="item in kelas" :value="item.id">{{ item.kelas }}</option>
            </Select>
            <template #footer>
                <Button color="success" @click="exportZip" :disabled="!kelasExport">Export</Button>
            </template>
        </Modal>
    </Layout>
</template>