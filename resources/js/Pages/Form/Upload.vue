<script setup>
import { Layout } from '@/Layouts'
import { Button, Spinner, Alert } from '@/Components'
import { useToast, useList } from '@/Composables'
import { Table, Th, Td } from '@/Components/Tables'
import { FileInput } from '@/Components/Form'
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import { isEmpty } from "lodash";
import { ref } from 'vue';

const checkBuku = ref({})

const formUpload = useForm({
    excel: null
})


function checkUpload() {
    formUpload.post(route('form.checkUpload'), {
        onSuccess: () => checkBuku.value = usePage().props.value.flash
    })
}

function upload() {
    formUpload.post(route('form.import'), {
        onSuccess: () => useToast(),
    })
}

</script>

<template>
    <Layout judul="Upload Buku">
        <form class="flex space-x-2" @submit.prevent="checkUpload">
            <FileInput required accept=".xlsx" v-model="formUpload.excel" />
            <Button type="submit" color="warning" :disabled="!formUpload.isDirty | formUpload.processing">
                <Spinner v-if="formUpload.processing" />
                <span v-else>Cek</span>
            </Button>
        </form>

        <Alert class="my-4" color="warning" :text="useList($page.props.flash?.fail)" v-if="$page.props.flash?.fail" />

        <template v-if="!isEmpty(checkBuku)">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                <div>
                    <b class="text-green-600">{{ checkBuku.ditambah.length }}</b>
                    <span> buku akan ditambah</span>
                    <Table class="max-h-96" :items="checkBuku.ditambah">
                        <template #head>
                            <Th>NIK</Th>
                            <Th>Judul</Th>
                        </template>
                        <template #body="{ item }">
                            <Td>{{ item.nik }}</Td>
                            <Td>{{ item.judul }}</Td>
                        </template>
                    </Table>
                </div>
                <div>
                    <span>
                        <b class="text-blue-600">{{ checkBuku.diupdate.length }}</b>
                        <span> buku akan diperbaharui</span>
                    </span>
                    <Table class="max-h-96" :items="checkBuku.diupdate">
                        <template #head>
                            <Th>NIK</Th>
                            <Th>Judul</Th>
                        </template>
                        <template #body="{ item }">
                            <Td>{{ item.nik }}</Td>
                            <Td>{{ item.judul }}</Td>
                        </template>
                    </Table>
                </div>
            </div>

            <Button class="mt-2" @click="upload" :disabled="formUpload.processing">
                <Spinner v-if="formUpload.processing" />
                <span v-else>Konfirmasi</span>
            </Button>
        </template>
    </Layout>
</template>