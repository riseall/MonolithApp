<script setup lang="ts">
import Sidebar from '@/Components/Sidebar.vue';
import axios from 'axios';
import { ref, computed, watch, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import BtnDelete from '@/Components/UI/BtnDelete.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import Swal from 'sweetalert2';

interface AbsenItem {
    id: string;
    foto: string;
    hari: string;
    tanggal: string;
    waktu: string;
    lokasi: string;
    mahasiswa: {
        nama: string
        nim: string
    } | null
}

const absenMasuk = ref<AbsenItem[]>([]);
const absenKeluar = ref<AbsenItem[]>([]);
const itemsPerPage = 5;
const currentPage = ref(1);
const currentPage_out = ref(1);

/* Get Data Absen Masuk */
const getAbMsk = async () => {
    await axios.get('api/absenMasuk', { params: { key: key.value } })
        .then(result => {
            absenMasuk.value = result.data.data;
        });
}

const totalItems = computed(() => absenMasuk.value.length);
const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage));

const displayedItems = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    return absenMasuk.value.slice(startIndex, endIndex);
});


const visPageNum = computed(() => {
    let pageNum = []
    if (totalPages.value <= 7) {
        for (let i = 1; i <= totalPages.value; i++) {
            pageNum.push(i);
        }
    } else {
        if (currentPage.value <= 4) {
            pageNum = [1, 2, 3, 4, 5, '....', totalPages.value];
        } else if (currentPage.value >= totalPages.value - 3) {
            pageNum = [1, '....', totalPages.value - 4, totalPages.value - 3, totalPages.value - 2, totalPages.value - 1, totalPages.value]
        } else {
            pageNum = [1, '....', currentPage.value, currentPage.value + 1, '....', totalPages.value]
        }
    }
    return pageNum;
});

const changePage = (page: number) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page
    }
}

//handle search item
const key = ref(null);
const res = ref<AbsenItem[]>([]);

watch(key, () => {
    getAbMsk();
})

/* Get Data Absen Keluar */
const getAbKlr = async () => {
    await axios.get('api/absenKeluar', { params: { keywords: keywords.value } })
        .then(result => {
            absenKeluar.value = result.data.data;
        });
}

const totalItems_out = computed(() => absenKeluar.value.length);
const totalPages_out = computed(() => Math.ceil(totalItems_out.value / itemsPerPage));

const displayedItems_out = computed(() => {
    const startIndex = (currentPage_out.value - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    return absenKeluar.value.slice(startIndex, endIndex);
});

const visPageOut = computed(() => {
    let pageNum = []
    if (totalPages_out.value <= 7) {
        for (let i = 1; i <= totalPages_out.value; i++) {
            pageNum.push(i);
        }
    } else {
        if (currentPage_out.value <= 4) {
            pageNum = [1, 2, 3, 4, 5, '....', totalPages_out.value];
        } else if (currentPage_out.value >= totalPages_out.value - 3) {
            pageNum = [1, '....', totalPages_out.value - 4, totalPages_out.value - 3, totalPages_out.value - 2, totalPages_out.value - 1, totalPages_out.value]
        } else {
            pageNum = [1, '....', currentPage_out.value, currentPage_out.value + 1, '....', totalPages_out.value]
        }
    }
    return pageNum;
});

const changeOut = (page: number) => {
    if (page >= 1 && page <= totalPages_out.value) {
        currentPage_out.value = page
    }
}

//handle search item
const keywords = ref(null);
const results = ref<AbsenItem[]>([]);

watch(keywords, () => {
    getAbKlr();
})

//handle untuk menghapus data
const deleteAbsMsk = (id: string) => {
    try {
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Anda tidak akan dapat mengembalikan ini!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(`api/absenMasuk/${id}`);
                getAbMsk();
                Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                });
            }
        });
    } catch (error) {
        // Handle errors here
        console.error('Error making DELETE request:', error);
    }
};

//handle untuk menghapus data
const deleteAbsKlr = (id: string) => {
    try {
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Anda tidak akan dapat mengembalikan ini!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(`api/absenKeluar/${id}`);
                getAbKlr();
                Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                });
            }
        });
    } catch (error) {
        // Handle errors here
        console.error('Error making DELETE request:', error);
    }
};

onMounted(() => {
    getAbMsk();
    getAbKlr();
});
</script>
<template>
    <Head title="Absensi" />
    <Sidebar>
        <!-- Data Absen Masuk -->
        <div class="block bg-white border border-gray-100 shadow-md shadow-black/5 rounded-lg p-6 overflow-auto">
            <div class="flex justify-between mb-4 mt-3 items-start-start">
                <h3 class="text-lg font-semibold text-left">Data Absen Masuk</h3>
                <div>
                    <input type="text" class="rounded-lg text-xs p-[0.3 rem]" v-model="key" placeholder="Search">
                    <ul v-if="res.length > 0">
                        <li v-for="i in res" :key="i.id" v-text="i.mahasiswa?.nama, i.hari, i.tanggal, i.waktu"></li>
                    </ul>
                </div>
            </div>
            <div class="overflow-x-auto rounded-lg">
                <table class="w-full align-middle border border-collapse">
                    <thead class="text-left text-gray-100 bg-gray-700 sticky top-0">
                        <tr class="table-row">
                            <th class="th-items">No</th>
                            <th class="th-items">Nama</th>
                            <th class="th-items">NIM</th>
                            <th class="th-items">Foto Absen</th>
                            <th class="th-items">Hari</th>
                            <th class="th-items">Tanggal</th>
                            <th class="th-items">Waktu Absen</th>
                            <th class="th-items">Lokasi Absen</th>
                            <th class="th-items">Hapus</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="odd:bg-gray-50" v-for="(Item, index) in displayedItems" :key="Item.id">
                            <td class="td-items">{{ (currentPage - 1) * itemsPerPage + index + 1 }}.</td>
                            <td class="td-items">{{ Item.mahasiswa?.nama ?? '-' }}</td>
                            <td class="td-items">{{ Item.mahasiswa?.nim ?? '-' }}</td>
                            <td class="rounded-lg">
                                <img :src="Item.foto" class="w-12 h-12 object-contain">
                            </td>
                            <td class="td-items">{{ Item.hari }}</td>
                            <td class="td-items">{{ Item.tanggal }}</td>
                            <td class="td-items">{{ Item.waktu }}</td>
                            <td class="td-items">
                                <a :href="Item.lokasi" target="_blank" class="flex text-sky-400 hover:text-sky-500">
                                    <FontAwesomeIcon icon="fa-solid fa-map-location-dot" class="mr-1 text-lg" />
                                    Lokasi
                                </a>
                            </td>
                            <td class="td-items">
                                <BtnDelete @click="deleteAbsMsk(Item.id)" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- Pagination -->
                <div class="py-2">
                    <nav class="block">
                        <p class="text-xs text-gray-700 font-semibold">Jumlah Data : {{ totalItems }}</p>
                        <ul class="flex pl-0 rounded list-none flex-wrap justify-center">
                            <li>
                                <a href="#" @click="changePage(currentPage - 1)" :disabled="(currentPage === 1)"
                                    class="first:ml-0 text-xs font-semibold flex w-8 h-8 mx-1 p-0 rounded-full items-center justify-center leading-tight relative border border-solid border-sky-500 bg-white text-sky-500 hover:bg-sky-300 hover:text-white">
                                    <FontAwesomeIcon icon="fas fa-chevron-left -ml-px" />
                                </a>
                            </li>
                            <li v-for="Items in visPageNum" :key="Items"
                                :class="{ active: currentPage == Items || Items === '....' }">
                                <a href="#" @click="changePage(Number(Items))"
                                    class="first:ml-0 text-xs font-semibold flex w-8 h-8 mx-1 p-0 rounded-full items-center justify-center leading-tight relative border border-solid border-sky-500 text-sky-400 focus:text-white focus:bg-sky-300 hover:bg-sky-300 hover:text-white">
                                    {{ Items }}
                                </a>
                            </li>
                            <li>
                                <a href="#" @click="changePage(currentPage + 1)" :disabled="(currentPage === 1)"
                                    class="first:ml-0 text-xs font-semibold flex w-8 h-8 mx-1 p-0 rounded-full items-center justify-center leading-tight relative border border-solid border-sky-500 bg-white text-sky-500 hover:bg-sky-300 hover:text-white">
                                    <FontAwesomeIcon icon="fas fa-chevron-right -ml-px" />
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Data Absen Keluar -->
        <div
            class="block my-10 mb-20 bg-white border border-gray-100 shadow-md shadow-black/5 rounded-lg p-6 overflow-auto">
            <div class="flex justify-between mb-4 mt-3 items-start-start">
                <h3 class="text-lg font-semibold text-left">Data Absen Keluar</h3>
                <div>
                    <input type="text" class="rounded-lg text-xs p-[0.3 rem]" v-model="keywords" placeholder="Search">
                    <ul v-if="results.length > 0">
                        <li v-for="result in results" :key="result.id"
                            v-text="result.hari, result.tanggal, result.waktu, result.lokasi"></li>
                    </ul>
                </div>
            </div>
            <div class="overflow-x-auto rounded-lg">
                <table class="w-full align-middle border border-collapse">
                    <thead class="text-left text-gray-100 bg-gray-700 sticky top-0">
                        <tr class="table-row">
                            <th class="th-items">No</th>
                            <th class="th-items">Nama</th>
                            <th class="th-items">NIM</th>
                            <th class="th-items">Foto Absen</th>
                            <th class="th-items">Hari</th>
                            <th class="th-items">Tanggal</th>
                            <th class="th-items">Waktu Absen</th>
                            <th class="th-items">Lokasi Absen</th>
                            <th class="th-items">Hapus</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="odd:bg-gray-50" v-for="(Item, index) in displayedItems_out" :key="Item.id">
                            <td class="td-items">{{ (currentPage_out - 1) * itemsPerPage + index + 1 }}.</td>
                            <td class="td-items">{{ Item.mahasiswa?.nama ?? '-' }}</td>
                            <td class="td-items">{{ Item.mahasiswa?.nim ?? '-' }}</td>
                            <td class="rounded-lg">
                                <img :src="Item.foto" class="w-12 h-12 object-contain">
                            </td>
                            <td class="td-items">{{ Item.hari }}</td>
                            <td class="td-items">{{ Item.tanggal }}</td>
                            <td class="td-items">{{ Item.waktu }}</td>
                            <td class="td-items">
                                <a :href="Item.lokasi" target="_blank" class="flex text-sky-400 hover:text-sky-500">
                                    <FontAwesomeIcon icon="fa-solid fa-map-location-dot" class="mr-1 text-lg" />
                                    Lokasi
                                </a>
                            </td>
                            <td class="td-items">
                                <BtnDelete @click="deleteAbsKlr(Item.id)" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- Pagination -->
                <div class="py-2">
                    <nav class="block">
                        <p class="text-xs text-gray-700 font-semibold">Jumlah Data : {{ totalItems_out }}</p>
                        <ul class="flex pl-0 rounded list-none flex-wrap justify-center">
                            <li>
                                <a href="#" @click="changeOut(currentPage_out - 1)" :disabled="(currentPage_out === 1)"
                                    class="first:ml-0 text-xs font-semibold flex w-8 h-8 mx-1 p-0 rounded-full items-center justify-center leading-tight relative border border-solid border-sky-500 bg-white text-sky-500 hover:bg-sky-300 hover:text-white">
                                    <FontAwesomeIcon icon="fas fa-chevron-left -ml-px" />
                                </a>
                            </li>
                            <li v-for="Items in visPageOut" :key="Items"
                                :class="{ active: currentPage_out == Items || Items === '....' }">
                                <a href="#" @click="changeOut(Number(Items))"
                                    class="first:ml-0 text-xs font-semibold flex w-8 h-8 mx-1 p-0 rounded-full items-center justify-center leading-tight relative border border-solid border-sky-500 text-sky-400 focus:text-white focus:bg-sky-300 hover:bg-sky-300 hover:text-white">
                                    {{ Items }}
                                </a>
                            </li>
                            <li>
                                <a href="#" @click="changeOut(currentPage_out + 1)" :disabled="(currentPage_out === 1)"
                                    class="first:ml-0 text-xs font-semibold flex w-8 h-8 mx-1 p-0 rounded-full items-center justify-center leading-tight relative border border-solid border-sky-500 bg-white text-sky-500 hover:bg-sky-300 hover:text-white">
                                    <FontAwesomeIcon icon="fas fa-chevron-right -ml-px" />
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </Sidebar>
</template>