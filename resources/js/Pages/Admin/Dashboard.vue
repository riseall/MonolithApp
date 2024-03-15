<script setup lang="ts">
import Sidebar from '@/Components/Sidebar.vue';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { computed, ref } from 'vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

/* Total absen masuk */
const absenMasuk = ref();
axios.get('api/absenMasuk')
    .then(result => {
        absenMasuk.value = result.data.data
    })
const totalItems = computed(() => {
    if (absenMasuk.value) {
        return absenMasuk.value.length;
    }
    return 0;
});

/* Total absen keluar */
const absenKeluar = ref();
axios.get('api/absenKeluar')
    .then(result => {
        absenKeluar.value = result.data.data
    })
const totalKeluar = computed(() => {
    if (absenKeluar.value) {
        return absenKeluar.value.length;
    }
    return 0;
});

/* Total user */
const user = ref();
axios.get('api/user')
    .then(result => {
        user.value = result.data.data
    })
const totalUser = computed(() => {
    if (user.value) {
        return user.value.length;
    }
    return 0;
});

/* Total Mahasiswa */
const mahasiswa = ref();
axios.get('api/mahasiswa')
    .then(result => {
        mahasiswa.value = result.data.data
    })
const totalmhs = computed(() => {
    if (mahasiswa.value) {
        return mahasiswa.value.length;
    }
    return 0;
});

/* Total Dosen */
const dosen = ref();
axios.get('api/dosen')
    .then(result => {
        dosen.value = result.data.data
    })
const totalDsn = computed(() => {
    if (dosen.value) {
        return dosen.value.length;
    }
    return 0;
});

/* Total Perusahaan */
const perusahaan = ref();
axios.get('api/perusahaan')
    .then(result => {
        perusahaan.value = result.data.data
    })
const totalPrsh = computed(() => {
    if (perusahaan.value) {
        return perusahaan.value.length;
    }
    return 0;
});

/* Total Magang */
const magang = ref();
axios.get('api/magang')
    .then(result => {
        magang.value = result.data.data
    })
const totalMgng = computed(() => {
    if (magang.value) {
        return magang.value.length;
    }
    return 0;
});

/* Total Laporan */
const laporan = ref();
axios.get('api/laporan')
    .then(result => {
        laporan.value = result.data.data
    })
const totalLprn = computed(() => {
    if (laporan.value) {
        return laporan.value.length;
    }
    return 0;
});
</script>
<template>
    <Head title="Dashboard" />

    <Sidebar>
        <div class="grid lg:grid-cols-4 gap-4 relative md:grid-cols-2">
            <div id="card" class="card group">
                <div class="flex items-center text-green-950 bg-green-500 justify-between p-4 pb-3">
                    <div>
                        <p class="font-bold">{{ totalItems }}</p>
                        <p class="text-sm">Absen Masuk</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-10 h-10 m-1 text-green-700 group-hover:scale-125 transition-all duration-500">
                        <path fill-rule="evenodd"
                            d="M5.625 1.5H9a3.75 3.75 0 013.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 013.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 01-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875zm5.845 17.03a.75.75 0 001.06 0l3-3a.75.75 0 10-1.06-1.06l-1.72 1.72V12a.75.75 0 00-1.5 0v4.19l-1.72-1.72a.75.75 0 00-1.06 1.06l3 3z"
                            clip-rule="evenodd" />
                        <path
                            d="M14.25 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963A5.23 5.23 0 0016.5 7.5h-1.875a.375.375 0 01-.375-.375V5.25z" />
                    </svg>
                </div>
                <Link href="absensi"
                    class="flex items-center justify-center py-1 text-green-300 bg-green-600 group-hover:text-green-400 group-hover:bg-green-700">
                <span class="text-sm">More Info</span>
                </Link>
            </div>
            <div id="card" class="card group">
                <div class="flex items-center text-rose-950 bg-rose-500 justify-between p-4 pb-3">
                    <div>
                        <p class="font-bold">{{ totalKeluar }}</p>
                        <p class="text-sm">Absen Keluar</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-10 h-10 m-1 text-rose-700 group-hover:scale-125 transition-all duration-500">
                        <path fill-rule="evenodd"
                            d="M5.625 1.5H9a3.75 3.75 0 013.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 013.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 01-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875zm6.905 9.97a.75.75 0 00-1.06 0l-3 3a.75.75 0 101.06 1.06l1.72-1.72V18a.75.75 0 001.5 0v-4.19l1.72 1.72a.75.75 0 101.06-1.06l-3-3z"
                            clip-rule="evenodd" />
                        <path
                            d="M14.25 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963A5.23 5.23 0 0016.5 7.5h-1.875a.375.375 0 01-.375-.375V5.25z" />
                    </svg>
                </div>
                <Link href="absensi"
                    class="flex items-center justify-center py-1 text-rose-300 bg-rose-600 group-hover:text-rose-400 group-hover:bg-rose-700">
                <span class="text-sm">More Info</span>
                </Link>
            </div>
            <div id="card" class="card group">
                <div class="flex items-center text-fuchsia-950 bg-fuchsia-500 justify-between p-4 pb-3">
                    <div>
                        <p class="font-bold">{{ totalUser }}</p>
                        <p class="text-sm">User</p>
                    </div>
                    <FontAwesomeIcon icon="fa-solid fa-users"
                        class="w-10 h-10 m-1 text-fuchsia-700 group-hover:scale-125 transition-all duration-500" />
                </div>
                <Link href="user"
                    class="flex items-center justify-center py-1 text-fuchsia-300 bg-fuchsia-600 group-hover:text-fuchsia-400 group-hover:bg-fuchsia-700">
                <span class="text-sm">More Info</span>
                </Link>
            </div>
            <div id="card" class="card group">
                <div class="flex items-center text-sky-950 bg-sky-500 justify-between p-4 pb-3">
                    <div>
                        <p class="font-bold">{{ totalmhs }}</p>
                        <p class="text-sm">Mahasiswa</p>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-10 h-10 m-1 text-sky-700 group-hover:scale-125 transition-all duration-500">
                        <path fill-rule="evenodd"
                            d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <Link href="mahasiswa"
                    class="flex items-center justify-center py-1 text-sky-300 bg-sky-600 group-hover:text-sky-400 group-hover:bg-sky-700">
                <span class="text-sm">More Info</span>
                </Link>
            </div>
            <div id="card" class="card group">
                <div class="flex items-center text-lime-950 bg-lime-500 justify-between p-4 pb-3">
                    <div>
                        <p class="font-bold">{{ totalDsn }}</p>
                        <p class="text-sm">Dosen</p>
                    </div>
                    <FontAwesomeIcon icon="fa-solid fa-user-tie"
                        class="w-10 h-10 m-1 text-lime-700 group-hover:scale-125 transition-all duration-500" />
                </div>
                <Link href="dosen"
                    class="flex items-center justify-center py-1 text-lime-300 bg-lime-600 group-hover:text-lime-400 group-hover:bg-lime-700">
                <span class="text-sm">More Info</span>
                </Link>
            </div>
            <div id="card" class="card group">
                <div class="flex items-center text-amber-950 bg-amber-500 justify-between p-4 pb-3">
                    <div>
                        <p class="font-bold">{{ totalPrsh }}</p>
                        <p class="text-sm">Perusahaan</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-10 h-10 m-1 text-amber-700 group-hover:scale-125 transition-all duration-500">
                        <path fill-rule="evenodd"
                            d="M4.5 2.25a.75.75 0 000 1.5v16.5h-.75a.75.75 0 000 1.5h16.5a.75.75 0 000-1.5h-.75V3.75a.75.75 0 000-1.5h-15zM9 6a.75.75 0 000 1.5h1.5a.75.75 0 000-1.5H9zm-.75 3.75A.75.75 0 019 9h1.5a.75.75 0 010 1.5H9a.75.75 0 01-.75-.75zM9 12a.75.75 0 000 1.5h1.5a.75.75 0 000-1.5H9zm3.75-5.25A.75.75 0 0113.5 6H15a.75.75 0 010 1.5h-1.5a.75.75 0 01-.75-.75zM13.5 9a.75.75 0 000 1.5H15A.75.75 0 0015 9h-1.5zm-.75 3.75a.75.75 0 01.75-.75H15a.75.75 0 010 1.5h-1.5a.75.75 0 01-.75-.75zM9 19.5v-2.25a.75.75 0 01.75-.75h4.5a.75.75 0 01.75.75v2.25a.75.75 0 01-.75.75h-4.5A.75.75 0 019 19.5z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <Link href="perusahaan"
                    class="flex items-center justify-center py-1 text-amber-300 bg-amber-600 group-hover:text-amber-400 group-hover:bg-amber-700">
                <span class="text-sm">More Info</span>
                </Link>
            </div>
            <div id="card" class="card group">
                <div class="flex items-center text-zinc-950 bg-zinc-500 justify-between p-4 pb-3">
                    <div>
                        <p class="font-bold">{{ totalMgng }}</p>
                        <p class="text-sm">Magang</p>
                    </div>
                    <FontAwesomeIcon icon="fa-solid fa-briefcase"
                        class="w-10 h-10 m-1 text-zinc-700 group-hover:scale-125 transition-all duration-500" />
                </div>
                <Link href="magang"
                    class="flex items-center justify-center py-1 text-zinc-300 bg-zinc-600 group-hover:text-zinc-400 group-hover:bg-zinc-700">
                <span class="text-sm">More Info</span>
                </Link>
            </div>
            <div id="card" class="card group">
                <div class="flex items-center text-teal-950 bg-teal-500 justify-between p-4 pb-3">
                    <div>
                        <p class="font-bold">{{ totalLprn }}</p>
                        <p class="text-sm">Laporan</p>
                    </div>
                    <FontAwesomeIcon icon="fa-solid fa-book"
                        class="w-8 h-10 m-1 text-teal-700 group-hover:scale-125 transition-all duration-500" />
                </div>
                <Link href="laporan"
                    class="flex items-center justify-center py-1 text-teal-300 bg-teal-600 group-hover:text-teal-400 group-hover:bg-teal-700">
                <span class="text-sm">More Info</span>
                </Link>
            </div>
        </div>
    </Sidebar>
</template>