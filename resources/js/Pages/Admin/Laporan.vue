<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import axios from 'axios';
import { computed, onMounted, ref, watch } from 'vue';
import BtnDelete from '@/Components/UI/BtnDelete.vue';
import Swal from 'sweetalert2'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

const errors = ref();

const itemsPerPage = 5;
const currentPage = ref(1);

type Laporan = {
    id: string,
    mahasiswa: {
        nama: string,
        nim: string,
        kelas: string
    },
    judul_laporan: string,
    laporan: string,
}

//Get 
const laporan = ref<Laporan[]>([]);
const getLaporan = async () => {
    await axios.get('api/laporan', { params: { keywords: keywords.value } })
        .then(res => {
            console.log(res)
            laporan.value = res.data.data
        });
};

//handle search item
const keywords = ref(null);
const results = ref<Laporan[]>([]);

watch(keywords, () => {
    getLaporan();
})

const totalItems = computed(() => laporan.value.length);
const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage));

const disDosen = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    return laporan.value.slice(startIndex, endIndex);
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

//handle untuk menghapus data
const deleteUser = (id: string) => {
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
                axios.delete(`api/laporan/${id}`);
                getLaporan();
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
    getLaporan();
})
</script>
<template>
    <Head title="Laporan" />

    <Sidebar>
        <div class="block bg-white border border-gray-100 shadow-md shadow-black/5 rounded-lg p-6 overflow-auto">
            <div class="flex justify-between mb-4 items-start-start">
                <h3 class="text-lg font-semibold text-left">Data Laporan</h3>
                <div class="flex items-start-start">
                    <input type="text" class="rounded-lg text-xs p-[0.3 rem]" v-model="keywords" placeholder="Search">
                    <ul v-if="results.length > 0">
                        <li v-for="result in results" :key="result.id" v-text="result.judul_laporan"></li>
                    </ul>
                </div>
            </div>
            <div class="overflow-x-auto rounded-lg">
                <!-- Table Laporan -->
                <table class="w-full align-middle border border-collapse">
                    <thead class="text-left text-gray-100 bg-gray-700 sticky top-0 rounded-lg">
                        <tr class="table-row">
                            <th class="th-items">No</th>
                            <th class="th-items">Nama</th>
                            <th class="th-items">Nim</th>
                            <th class="th-items">Judul Laporan</th>
                            <th class="th-items">Laporan</th>
                            <th class="th-items">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="odd:bg-gray-50" v-for="(Item, index) in disDosen" :key="Item.id">
                            <td class="td-items">{{ (currentPage - 1) * itemsPerPage + index + 1 }}.</td>
                            <td class="td-items">{{ Item.mahasiswa?.nama ?? '-' }}</td>
                            <td class="td-items">{{ Item.mahasiswa?.nim ?? '-' }}</td>
                            <td class="td-items">{{ Item.judul_laporan }}</td>
                            <td class="td-items"><a :href="Item.laporan" target="_blank"
                                    class="flex text-sky-400 hover:text-sky-500">
                                    <FontAwesomeIcon icon="fa-solid fa-file-pdf" class="mr-1 text-lg" />
                                    Laporan
                                </a></td>
                            <td class="p-3 text-white">
                                <BtnDelete @click="deleteUser(Item.id)" />
                            </td>
                        </tr>
                    </tbody>
                </table>
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
                <!-- End Table Laporan -->
            </div>
        </div>
    </Sidebar>
</template>