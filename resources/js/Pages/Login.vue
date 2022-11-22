<script setup>
import { Input, Switch } from "@/Components/Form";
import { Button } from "@/Components";
import { EyeIcon, EyeSlashIcon } from '@heroicons/vue/24/outline'
import { ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";

const isHide = ref(true)
const formLogin = useForm({
    nama: null,
    password: null,
    remember: true,
})


function login() {
    formLogin.post(route('login'))
}

</script>

<template>
    <div class="flex justify-center">
        <div class="border m-auto p-4 md:w-96 w-80 mt-24">
            <img src="/storage/images/logo.png" alt="logo" class="mx-auto w-24 mb-4">
            <form @submit.prevent="login">
                <div class="space-y-3">
                    <Input placeholder="nama" required v-model="formLogin.nama" />
                    <div class="relative">
                        <Input placeholder="password" :type="isHide ? 'password' : 'text'" required
                            v-model="formLogin.password" />
                        <div class="absolute right-2 top-2 clickable">
                            <EyeSlashIcon class="w-5 h-5 text-slate-500" :class="{ 'hidden': !isHide }"
                                @click="isHide = !isHide" />
                            <EyeIcon class="w-5 h-5" :class="{ 'hidden': isHide }" @click="isHide = !isHide" />
                        </div>
                    </div>
                    <Switch v-model="formLogin.remember">Ingat Saya</Switch>
                </div>
                <div class="mt-6 flex justify-between">
                    <Button type="submit">Login</Button>
                    <div class="font-semibold text-red-600">
                        {{ $attrs.errors.fail }}
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>