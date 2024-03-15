<script setup lang="ts">
import Sidebar from '@/Components/Sidebar.vue';
import BlueButton from '@/Components/UI/BlueButton.vue';
import RedButton from '@/Components/UI/RedButton.vue';
import BtnDelete from '@/Components/UI/BtnDelete.vue';
import BtnEdit from '@/Components/UI/BtnEdit.vue';
import BtnTutup from '@/Components/UI/BtnTutup.vue';
import axios from 'axios';
import { computed, onMounted, ref } from 'vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { AxiosError } from 'axios';
import Swal from 'sweetalert2';
import ModalDialog from '@/Components/ModalDialog.vue';

const errors = ref();
const isOpen = ref(false);
const isEditVal = ref(false);

const closeModal = () => {
    isOpen.value = false
    isEditVal.value = false
    formData.value =
    {
        id: '',
        mahasiswa_id: '',
        perusahaan_id: '',
        periode: '',
        posisi: '',
        dosen_id: '',
        laporan_id: ''
    };
}
const openModal = () => {
    isOpen.value = true
    errors.value = '';
}
const editModal = (item: any) => {
    isOpen.value = true
    isEditVal.value = true
    formData.value = item
}

const itemsPerPage = 5;
const currentPage = ref(1);

const formData = ref({
    id: '',
    mahasiswa_id: '',
    perusahaan_id: '',
    periode: '',
    posisi: '',
    dosen_id: '',
    laporan_id: ''
});

type Magang = {
    id: string,
    mahasiswa: { nama: string, nim: string, kelas: string } | null,
    perusahaan: { nama: string },
    periode: Date,
    posisi: string,
    dosen: { nama: string },
    laporan: { judul_laporan: string },
}

const magang = ref<Magang[]>([]);
//get data mahasiswa magang
const getData = async () => {
    await axios.get('api/magang')
        .then(result => {
            console.log(result)
            magang.value = result.data.data
        });
}
const totalItems = computed(() => magang.value.length);
const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage));

const displayItem = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    return magang.value.slice(startIndex, endIndex);
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
const keywords = ref(null);
const results = ref<Magang[]>([]);

const postData = async () => {
    const form = new FormData();
    form.append('mahasiswa_id', formData.value.mahasiswa_id);
    form.append('perusahaan_id', formData.value.perusahaan_id);
    form.append('periode', formData.value.periode);
    form.append('posisi', formData.value.posisi);
    form.append('dosen_id', formData.value.dosen_id);
    form.append('laporan_id', formData.value.laporan_id);
    try {
        const response = await axios.post('api/magang', form);
        // response sukses
        console.log('Berhasil Menambahkan Data', response.data);
        Swal.fire({
            title: "Yeayy!",
            text: "Berhasil Menambahkan Data.",
            icon: "success"
        });
        closeModal()
        getData()
    } catch (error: unknown) {
        // response error
        if (error instanceof AxiosError) {
            errors.value = error.response?.data.errors;
        }
        console.error('Post gagal:', error);
    }
}

const updateData = async () => {
    try {
        const response = await axios.put(`api/magang/${formData.value.id}`, formData.value);
        // response sukses
        console.log('Berhasil Mengubah Data', response.data);
        Swal.fire({
            title: "Yeayy!",
            text: "Berhasil Mengubah Data.",
            icon: "success"
        });
        getData()
        closeModal();
    } catch (error: unknown) {
        // response error
        if (error instanceof AxiosError) {
            errors.value = error.response?.data.errors;
        }
        console.error('Post gagal:', error);
    }
}

interface Mahasiswa {
    nama: string;
    id: number;
    judul_laporan: string;
}

let mhs = ref<Mahasiswa[]>([]);
const getMhs = () => { axios.get('api/mahasiswa').then(res => { mhs.value = res.data.data }) }
let prs = ref<Mahasiswa[]>([]);
const getPrs = () => { axios.get('api/perusahaan').then(res => { prs.value = res.data.data }) }
let dsn = ref<Mahasiswa[]>([]);
const getDsn = () => { axios.get('api/dosen').then(res => { dsn.value = res.data.data }) }
let lpr = ref<Mahasiswa[]>([]);
const getLpr = () => { axios.get('api/laporan').then(res => { lpr.value = res.data.data }) }

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
                const response = axios.delete(`api/magang/${id}`);
                getData();
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
    getData();
    getMhs();
    getPrs();
    getDsn();
    getLpr();
})
</script>
<template>
    <Sidebar>
        <div class="block w-full bg-white border border-gray-100 shadow-md shadow-black/5 rounded-lg p-6 overflow-auto">
            <h3 class="text-lg font-semibold text-left">Data Magang Mahasiswa</h3>
            <div class="flex justify-between mb-4 mt-3 items-start-start">
                <div>
                    <input type="text" class="rounded-lg text-xs p-[0.3 rem]" v-model="keywords" placeholder="Search">
                    <ul v-if="results.length > 0">
                        <li v-for="result in results" :key="result.id"></li>
                    </ul>
                </div>
                <BlueButton @click="openModal">Tambah Data</BlueButton>
            </div>
            <div class="overflow-x-auto rounded-lg">
                <!-- Table Mahasiswa -->
                <table class="w-full align-middle border border-collapse">
                    <thead class="text-left text-gray-100 bg-gray-700 sticky top-0 rounded-lg">
                        <tr class="table-row">
                            <th class="th-items">No</th>
                            <th class="th-items">Nama</th>
                            <th class="th-items">NIM</th>
                            <th class="th-items">Kelas</th>
                            <th class="th-items">Perusahaan</th>
                            <th class="th-items">Periode</th>
                            <th class="th-items">Posisi</th>
                            <th class="th-items">Dosen Pembimbing</th>
                            <th class="th-items">Judul Laporan</th>
                            <th class="th-items">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="odd:bg-gray-50" v-for="(Item, index) in displayItem" :key="Item.id">
                            <td class="td-items">{{ index + 1 }}.</td>
                            <td class="td-items">{{ Item.mahasiswa?.nama ?? '-' }}</td>
                            <td class="td-items">{{ Item.mahasiswa?.nim ?? '-' }}</td>
                            <td class="td-items">{{ Item.mahasiswa?.kelas ?? '-' }}</td>
                            <td class="td-items">{{ Item.perusahaan?.nama ?? '-' }}</td>
                            <td class="td-items">{{ Item.periode }}</td>
                            <td class="td-items">{{ Item.posisi }}</td>
                            <td class="td-items">{{ Item.dosen?.nama ?? '-' }}</td>
                            <td class="td-items">{{ Item.laporan?.judul_laporan ?? '-' }}</td>
                            <td class="p-3 text-white">
                                <div class="flex items-center space-x-2">
                                    <BtnEdit @click="editModal(Item)" />
                                    <BtnDelete @click="deleteUser(Item.id)" />
                                </div>
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
                <!-- End Table Magang Mahasiswa -->
            </div>
        </div>

        <!-- Tambah data Magang  -->
        <ModalDialog :is-open="isOpen" @close="closeModal">
            <template v-slot:jdlDialog>T{{ isEditVal ? 'Edit Data Magang' : 'Tambah Data Magang' }}</template>
            <template v-slot:btn>
                <BtnTutup @click="closeModal" />
            </template>
            <div class="flex-auto px-2 lg:px-5 py-5 pb-0">
                <form>
                    <div class="flex flex-wrap mt-3">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="block text-gray-900 text-xs font-bold mb-2 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Mahasiswa
                                </label>
                                <select name="" id="" v-model="formData.mahasiswa_id" class="input-form">
                                    <option class="bg-slate-300" value="">Masukkan Nama Mahasiswa</option>
                                    <option v-for="(M, index) in mhs" class="bg-slate-300" :key="index" :value="M.id">{{
                                        M.nama }}</option>
                                </select>
                                <div class="text-red-400 text-sm" v-if="errors?.mahasiswa_id">{{ errors.mahasiswa_id[0] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mt-3">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="block text-gray-900 text-xs font-bold mb-2 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Perusahaan
                                </label>
                                <select name="" id="" v-model="formData.perusahaan_id" class="input-form">
                                    <option value="">Masukkan Nama Perusahaan</option>
                                    <option v-for="(M, index) in prs" class="bg-slate-300" :key="index" :value="M.id">{{
                                        M.nama }}</option>
                                </select>
                                <div class="text-red-400 text-sm" v-if="errors?.perusahaan_id">{{ errors.perusahaan_id[0] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mt-3">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="block text-gray-900 text-xs font-bold mb-2 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Periode
                                </label>
                                <input type="text" placeholder="Periode" class="input-form" v-model="formData.periode">
                                <!-- <VueDatePicker class="text-sm" v-model="formData.periode" range format="dd/MM/yyyy">
                                </VueDatePicker> -->
                                <div class="text-red-400 text-sm" v-if="errors?.periode">{{ errors.periode[0] }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mt-3">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="block text-gray-900 text-xs font-bold mb-2 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Posisi
                                </label>
                                <input type="text" placeholder="Posisi" class="input-form" v-model="formData.posisi">
                                <div class="text-red-400 text-sm" v-if="errors?.posisi">{{ errors.posisi[0] }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mt-3">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label class="block text-gray-900 text-xs font-bold mb-2">
                                    Dosen
                                </label>
                                <select name="" id="" v-model="formData.dosen_id" class="input-form">
                                    <option value="">Masukkan Nama Dosen</option>
                                    <option v-for="(M, index) in dsn" class="bg-slate-300" :key="index" :value="M.id">{{
                                        M.nama }}</option>
                                </select>
                                <div class="text-red-400 text-sm" v-if="errors?.dosen_id">{{ errors.dosen_id[0] }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mt-3">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label class="block text-gray-900 text-xs font-bold mb-2">
                                    Laporan
                                </label>
                                <select name="" id="" v-model="formData.laporan_id" class="input-form">
                                    <option value="">Masukkan Judul Laporan</option>
                                    <option v-for="(M, index) in lpr" class="bg-slate-300" :key="index" :value="M.id">{{
                                        M.judul_laporan }}</option>
                                </select>
                                <div class="text-red-400 text-sm" v-if="errors?.laporan_id">{{ errors.laporan_id[0] }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-t mb-0 px-6 py-6">
                        <div class="text-center flex justify-end">
                            <BlueButton @click="isEditVal ? updateData() : postData()" class="mr-2">
                                Simpan</BlueButton>
                            <RedButton @click="closeModal">Batal</RedButton>
                        </div>
                    </div>
                </form>
            </div>
        </ModalDialog>
    </Sidebar>
</template>

<style lang="css">
.custom-time-picker-component {
    display: flex;
    align-items: center;
    justify-content: center;
}

.select-input {
    margin: 5px 3px;
    padding: 5px;
    width: 100px;
    border-radius: 4px;
    border-color: var(--dp-border-color);
    outline: none;
}
</style>