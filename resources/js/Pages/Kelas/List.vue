<script setup>
import { Layout } from '@/Layouts'
import { Button } from "@/Components";
import { Table, Th, Td } from "@/Components/Tables";
import { Select, Checkbox } from "@/Components/Form";
import { useForm } from '@inertiajs/inertia-vue3';
import { useToast } from "@/Composables";
import { isEmpty } from "lodash";

const props = defineProps({
    judul: String,
    siswa: {
        type: Array,
        default: () => []
    },
    kelas: {
        type: Array,
        default: () => []
    }
})

const formUpdate = useForm({
    kelas: null,
    siswa: []
})


function checkAll(e) {
    formUpdate.siswa = e.target.checked
        ? props.siswa.map(v => v.id)
        : []
}

function update() {
    formUpdate.patch(route('kelas.updateList'), {
        onSuccess: () => useToast()
    })
}

</script>

<template>
    <Layout :judul="judul">
        <Table :items="siswa">
            <template #head>
                <Th>No</Th>
                <Th>Nama</Th>
                <Th>NIS</Th>
                <Th>
                    <Checkbox @change="checkAll($event)" />
                </Th>
            </template>
            <template #body="{ item, key }">
                <Th>{{ key + 1 }}</Th>
                <Td :text="item.nama" />
                <Td :text="item.nis" />
                <Td>
                    <Checkbox v-model="formUpdate.siswa" :value="item.id" />
                </Td>
            </template>
        </Table>

        <form @submit.prevent="update" class="mt-4 flex space-x-2 md:w-1/2">
            <Select v-model="formUpdate.kelas" required>
                <option v-for="item in kelas" :value="item.id">{{ item.kelas }}</option>
            </Select>
            <Button color="success" type="submit"
                :disabled="!formUpdate.isDirty || isEmpty(formUpdate.siswa) || !formUpdate.kelas">Simpan</Button>
        </form>
    </Layout>
</template>