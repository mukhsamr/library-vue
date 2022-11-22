<script setup>
import { Layout } from '@/Layouts';
import { Datalist, Textarea } from '@/Components/Form';
import { Button } from '@/Components';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { isEmpty } from "lodash";
import { TrashIcon } from '@heroicons/vue/24/outline'
import { useForm } from '@inertiajs/inertia-vue3';
import { useToast } from "@/Composables";

const props = defineProps({
    listBuku: {
        type: Array,
        default: () => []
    },
    nikBuku: String,
    buku: {
        type: Object,
        default: () => ({})
    }

})

const nikBuku = ref(props.nikBuku)
const formHapus = useForm({
    catatan: null
})


function cari() {
    Inertia.get(route('form.hapus', { nik: nikBuku.value }))
}

function hapus() {
    formHapus.delete(route('form.remove', props.buku.id), {
        onSuccess: () => useToast(),
    })
}


</script>

<template>

    <Layout judul="Hapus Buku">
        <div class="grid grid-cols-2 gap-4">
            <form class="flex space-x-2" @submit.prevent="cari">
                <Datalist v-model="nikBuku" placeholder="cari nik / judul / scan barcode">
                    <option v-for="buku in listBuku" :value="buku.nik">{{ buku.judul }}</option>
                </Datalist>
                <Button type="submit">Cari</Button>
            </form>

            <div class="flex justify-end">
                <Button color="dark" @click="$inertia.get(route('form.trash'))">Buku Dihapus</Button>
            </div>
        </div>

        <div class="grid grid-cols-6 gap-4 mt-4" v-if="!isEmpty(buku)">
            <div class="col-span-2">
                <div class="p-2 border">
                    <img :src="'/storage/sampul/' + (buku.sampul ?? 'contoh.png')" alt="sampul">
                </div>
            </div>
            <div class="col-span-4">
                <span class="font-semibold">{{ buku.judul }}</span>
                <hr class="my-2">
                <form @submit.prevent="hapus">
                    <Textarea v-model="formHapus.catatan" placeholder="Catatan" />
                    <Button type="submit" color="danger" :icon="TrashIcon" class="mt-2">Hapus</Button>
                </form>
            </div>
        </div>
    </Layout>
</template>