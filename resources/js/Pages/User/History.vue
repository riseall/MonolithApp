<script setup lang="ts">
import NavbarBottom from '@/Components/User/NavbarBottom.vue';
import axios from 'axios';
import { onMounted, ref, } from 'vue';
import { Head } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

interface AbsenItem {
    hari: string;
    tanggal: string;
    waktu: string;
    type: string;
    icon: string;
    color: string;
    warna: string
    // tambahkan properti lain jika ada
}

const absenMasuk = ref<AbsenItem[]>([]);
const absenKeluar = ref<AbsenItem[]>([]);
const combinedAbsen = ref<AbsenItem[]>([]);

onMounted(async () => {
    const resultMasuk = await axios.get(`api/masukk`);
    absenMasuk.value = resultMasuk.data.data.map((item: AbsenItem) => ({
        ...item,
        type: 'Absen Masuk',
        icon: 'fa-solid fa-arrow-right-to-bracket',
        color: 'border bg-gradient-to-br from-green-700 via-green-600 to-green-400 rounded-xl shadow-lg overflow-hidden p-4 border border-gray-500',
        warna: 'p-3 rounded-full mr-5 bg-green-300/50'
    }));

    const resultKeluar = await axios.get('api/keluarr');
    absenKeluar.value = resultKeluar.data.data.map((item: AbsenItem) => ({
        ...item,
        type: 'Absen Keluar',
        icon: 'fa-solid fa-arrow-right-from-bracket',
        color: 'border bg-gradient-to-br from-red-700 via-red-500 to-red-400 rounded-xl shadow-lg overflow-hidden p-4 border border-gray-500',
        warna: 'p-3 rounded-full mr-5 bg-red-300/50'
    }));

    for (let i = 0; i < absenMasuk.value.length; i++) {
        if (absenKeluar.value[i]) {
            combinedAbsen.value.push(absenMasuk.value[i], absenKeluar.value[i]);
        } else {
            combinedAbsen.value.push(absenMasuk.value[i]);
        }
    }
    combinedAbsen.value.join(', ')
});
</script>
<template>
    <Head title="History" />

    <NavbarBottom>
        <header class="h-14 flex items-end justify-center p-2 bg-white shadow-lg sticky top-0 z-10">
            <h1 class="font-semibold">Riwayat Absensi</h1>
        </header>

        <main class="m-5">
            <div class="grid gap-3 relative lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-1">
                <div v-for="item in combinedAbsen" :class="item.color">
                    <div class="flex px-3 items-center">
                        <div class="p-3 rounded-full mr-5" :class="item.warna">
                            <FontAwesomeIcon :icon="item.icon" class="mx-[0.15rem] text-2xl text-white" />
                        </div>
                        <div class="flex flex-col text-sm text-white">
                            <h1 class="font-semibold">{{ item.type }}</h1>
                            <span class="text-xs">{{ item.hari }}, {{ item.tanggal }}</span>
                            <span class="text-xs">{{ item.waktu }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </NavbarBottom>
</template>