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
    staff: {
        type: Array,
        default: () => []
    },
    unit: {
        type: Array,
        default: () => []
    }
})

const formUpdate = useForm({
    unit: null,
    staff: []
})


function checkAll(e) {
    formUpdate.staff = e.target.checked
        ? props.staff.map(v => v.id)
        : []
}

function update() {
    formUpdate.patch(route('unit.updateList'), {
        onSuccess: () => useToast()
    })
}

</script>

<template>
    <Layout :judul="judul">
        <Table :items="staff">
            <template #head>
                <Th>No</Th>
                <Th>Nama</Th>
                <Th>NIK</Th>
                <Th>
                    <Checkbox @change="checkAll($event)" />
                </Th>
            </template>
            <template #body="{ item, key }">
                <Th>{{ key + 1 }}</Th>
                <Td :text="item.nama" />
                <Td :text="item.nik" />
                <Td>
                    <Checkbox v-model="formUpdate.staff" :value="item.id" />
                </Td>
            </template>
        </Table>

        <form @submit.prevent="update" class="mt-4 flex space-x-2 md:w-1/2">
            <Select v-model="formUpdate.unit" required>
                <option v-for="item in unit" :value="item.id">{{ item.unit }}</option>
            </Select>
            <Button color="success" type="submit"
                :disabled="!formUpdate.isDirty || isEmpty(formUpdate.staff) || !formUpdate.unit">Simpan</Button>
        </form>
    </Layout>
</template>