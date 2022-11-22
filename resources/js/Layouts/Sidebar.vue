<script setup>
import { inject, ref } from 'vue';
import { SideLink, MultiLink } from '@/Components';
import { ClipboardIcon, NewspaperIcon, RectangleStackIcon, PrinterIcon, CalendarIcon, ArchiveBoxIcon, UserIcon, ViewColumnsIcon, HomeIcon } from '@heroicons/vue/24/outline'
import { UserIcon as UserIconSolid, ViewColumnsIcon as ViewColumnsIconSolid } from '@heroicons/vue/24/solid'
import { Link } from '@inertiajs/inertia-vue3';

const emitter = inject('mitt')
const hideSidebar = ref(window.screen.width < 992)

function toggleSidebar() {
    hideSidebar.value = !hideSidebar.value
}

emitter.on('toggleSidebar', toggleSidebar)


</script>

<template>
    <div class="sticky top-0 z-40">

        <div class="fixed inset-0 bg-black/30 md:hidden" :class="{ 'hidden': hideSidebar }"
            @click.self="toggleSidebar" />

        <div class="w-60 h-full min-h-screen shadow-md bg-white fixed" id="sideBar"
            :class="{ '-translate-x-full': hideSidebar }">

            <!-- Avatar -->
            <div class="pt-4 pb-2 px-6">
                <div class="flex items-center">
                    <div class="w-16 h-16">
                        <div class="rounded-full w-full h-full overflow-hidden">
                            <img :src="'/storage/images/' + ($page.props.user?.foto ? $page.props.user?.foto : 'user.jpg')"
                                class="w-full h-full object-cover object-center select-none" alt="Foto Profil">
                        </div>
                    </div>
                    <div class="grow ml-3">
                        <p class="text-sm font-semibold text-blue-600">{{ $page.props.user?.nama }}</p>
                    </div>
                </div>
            </div>

            <hr class="my-2">

            <!-- Links -->
            <ul class="relative px-1">

                <!-- Beranda -->
                <SideLink :icon="HomeIcon" text="Beranda" :href="route('beranda')"
                    :class="{ 'text-blue-600 bg-blue-100 font-semibold': $page.url == '/' }" />


                <!-- Buku -->
                <SideLink :icon="ClipboardIcon" text="Daftar Buku" :href="route('buku.daftar')" active="/buku/daftar" />
                <SideLink :icon="NewspaperIcon" text="Detail Buku" :href="route('buku.detail')" active="/buku/detail" />

                <!-- Form -->
                <MultiLink id="Form" text="Form" :icon="RectangleStackIcon" active="/form">
                    <Link :href="route('form.upload')">Upload</Link>
                    <Link :href="route('form.tambah')">Tambah</Link>
                    <Link :href="route('form.edit')">Edit</Link>
                    <Link :href="route('form.hapus')">Hapus</Link>
                </MultiLink>

                <!-- Peminjaman -->
                <MultiLink id="Peminjaman" text="Peminjaman" :icon="CalendarIcon" active="/peminjaman">
                    <Link :href="route('peminjaman.form')">Form</Link>
                    <Link :href="route('peminjaman.riwayat')">Riwayat</Link>
                </MultiLink>

                <!-- Print -->
                <MultiLink id="Print" text="Print" :icon="PrinterIcon" active="/print">
                    <Link :href="route('print.buku')">Buku</Link>
                    <Link :href="route('print.siswa')">Siswa</Link>
                    <Link :href="route('print.staff')">Karyawan</Link>
                </MultiLink>

                <!-- Rekap -->
                <MultiLink id="Rekap" text="Rekap" :icon="ArchiveBoxIcon" active="/rekap">
                    <Link :href="route('rekap.siswa')">Siswa</Link>
                    <Link :href="route('rekap.staff')">Karyawan</Link>
                </MultiLink>

                <hr class="my-2">

                <template v-if="$page.props.user?.level == 3">

                    <!-- Database -->
                    <SideLink :icon="UserIcon" text="Siswa" :href="route('siswa.index')" active="/siswa" />
                    <SideLink :icon="UserIconSolid" text="Karyawan" :href="route('staff.index')" active="/staff" />
                    <SideLink :icon="ViewColumnsIcon" text="Kelas" :href="route('kelas.index')" active="/kelas" />
                    <SideLink :icon="ViewColumnsIconSolid" text="Unit" :href="route('unit.index')" active="/unit" />

                    <hr class="my-2">
                </template>

            </ul>
        </div>

    </div>


</template>