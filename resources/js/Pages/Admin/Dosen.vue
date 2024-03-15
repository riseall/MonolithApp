<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import BlueButton from '@/Components/UI/BlueButton.vue';
import axios from 'axios';
import { Ref, computed, onMounted, ref, watch } from 'vue';
import BtnEdit from '@/Components/UI/BtnEdit.vue';
import BtnDelete from '@/Components/UI/BtnDelete.vue';
import RedButton from '@/Components/UI/RedButton.vue';
import ModalDialog from '@/Components/ModalDialog.vue';
import BtnTutup from '@/Components/UI/BtnTutup.vue';
import { AxiosError } from 'axios';
import Swal from 'sweetalert2'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

const errors = ref();
const isOpen = ref(false);
const isEdit = ref(false);

const closeModal = () => {
    isOpen.value = false
    isEdit.value = false
}
const openModal = () => {
    isOpen.value = true
    errors.value = '';
}
const editModal = (id: string) => {
    isEdit.value = true
    const selectedDosen = dosen.value.find((item) => {
        return item.id === id
    })
    form.value.id = selectedDosen?.id ?? '-'
    form.value.nip = selectedDosen?.nip ?? ''
    form.value.nama = selectedDosen?.nama ?? ''
    form.value.telepon = selectedDosen?.telepon ?? ''
    form.value.alamat = selectedDosen?.alamat ?? ''
}

const editClose = () => {
    isEdit.value = false
    form.value =
    {
        id: '',
        nip: '',
        nama: '',
        telepon: '',
        alamat: ''
    };
}

const itemsPerPage = 5;
const currentPage = ref(1);

type Dosen = {
    id: string,
    nip: string,
    nama: string,
    telepon: string,
    alamat: string,
}

//Get 
const dosen = ref<Dosen[]>([]);
const getDosen = async () => {
    await axios.get('api/dosen', { params: { keywords: keywords.value } })
        .then(res => {
            console.log(res)
            dosen.value = res.data.data
        });
};

//handle search item
const keywords = ref(null);
const results = ref<Dosen[]>([]);

watch(keywords, () => {
    getDosen();
})

const totalItems = computed(() => dosen.value.length);
const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage));

const disDosen = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    return dosen.value.slice(startIndex, endIndex);
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

//Post data dosen
const form: Ref<Dosen> = ref({
    id: '',
    nip: '',
    nama: '',
    telepon: '',
    alamat: ''
});

const createDosen = async () => {
    await axios.post('api/dosen', form.value)
        .then(res => {
            console.log(res);
            // response sukses
            Swal.fire({
                title: "Yeayy!",
                text: "Berhasil Menambahkan Data.",
                icon: "success"
            });
            isOpen.value = false;
            getDosen()
            form.value =
            {
                id: '',
                nip: '',
                nama: '',
                telepon: '',
                alamat: ''
            };
        })
        .catch(error => {
            if (error instanceof AxiosError) {
                errors.value = error.response?.data.errors;
            }
            console.error('Post gagal:', error);
        })
}

const updateDosen = async () => {
    await axios.put(`api/dosen/${form.value.id}`, form.value)
        .then(res => {
            console.log(res)
            // response sukses
            Swal.fire({
                title: "Yeayy!",
                text: "Berhasil Mengubah Data.",
                icon: "success"
            });
            isEdit.value = false;
            getDosen()
        });
};

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
                axios.delete(`api/dosen/${id}`);
                getDosen();
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
    getDosen();
})
</script>
<template>
    <Head title="Dosen" />

    <Sidebar>
        <div class="block bg-white border border-gray-100 shadow-md shadow-black/5 rounded-lg p-6 overflow-auto">
            <div class="flex mb-4 items-start-start">
                <h3 class="text-lg font-semibold text-left">Data Dosen</h3>
            </div>
            <div class="flex justify-between mb-4 items-start-start">
                <div>
                    <input type="text" class="rounded-lg text-xs p-[0.3 rem]" v-model="keywords" placeholder="Search">
                    <ul v-if="results.length > 0">
                        <li v-for="result in results" :key="result.id" v-text="result.nama, result.nip, result.alamat"></li>
                    </ul>
                </div>
                <BlueButton @click="openModal">Tambah Data</BlueButton>
            </div>
            <div class="overflow-x-auto rounded-lg">
                <!-- Table Dosen -->
                <table class="w-full align-middle border border-collapse">
                    <thead class="text-left text-gray-100 bg-gray-700 sticky top-0 rounded-lg">
                        <tr class="table-row">
                            <th class="th-items">No</th>
                            <th class="th-items">NIP</th>
                            <th class="th-items">Nama</th>
                            <th class="th-items">Telepon</th>
                            <th class="th-items">Alamat</th>
                            <th class="th-items">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="odd:bg-gray-50" v-for="(Item, index) in disDosen" :key="Item.id">
                            <td class="td-items">{{ (currentPage - 1) * itemsPerPage + index + 1 }}.</td>
                            <td class="td-items">{{ Item.nip }}</td>
                            <td class="td-items">{{ Item.nama }}</td>
                            <td class="td-items">{{ Item.telepon }}</td>
                            <td class="td-items">{{ Item.alamat }}</td>
                            <td class="p-3 text-white">
                                <div class="flex items-center space-x-2">
                                    <BtnEdit @click="editModal(Item.id)" />
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
                <!-- End Table Dosen -->
            </div>
        </div>

        <!-- Tambah data Dosen -->
        <ModalDialog :is-open="isOpen" @close="closeModal">
            <template v-slot:jdlDialog>Tambah Data Dosen</template>
            <template v-slot:btn>
                <BtnTutup @click="closeModal" />
            </template>
            <div class="flex-auto px-2 lg:px-5 py-5 pb-0">
                <form @submit.prevent="createDosen">
                    <div class="flex flex-wrap mt-3">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="block uppercase text-blueGray-600 text-xs font-bold mb-2 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    NIP
                                </label>
                                <input type="text" placeholder="NIP" class="input-form" v-model="form.nip">
                                <div class="text-red-400 text-sm" v-if="errors?.nip">{{ errors.nip[0] }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mt-3">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="block uppercase text-blueGray-600 text-xs font-bold mb-2 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Nama
                                </label>
                                <input type="text" placeholder="Nama" class="input-form" v-model="form.nama">
                                <div class="text-red-400 text-sm" v-if="errors?.nama">{{ errors.nama[0] }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mt-3">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="block uppercase text-blueGray-600 text-xs font-bold mb-2 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Telepon
                                </label>
                                <input type="text" placeholder="Telepon" class="input-form" v-model="form.telepon">
                                <div class="text-red-400 text-sm" v-if="errors?.telepon">{{ errors.telepon[0] }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mt-3">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="block uppercase text-blueGray-600 text-xs font-bold mb-2 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Alamat
                                </label>
                                <input type="text" placeholder="Alamat" class="input-form" v-model="form.alamat">
                                <div class="text-red-400 text-sm" v-if="errors?.alamat">{{ errors.alamat[0] }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-t mb-0 px-6 py-6">
                        <div class="text-center flex justify-end">
                            <BlueButton type="submit" class="mr-2">Simpan</BlueButton>
                            <RedButton @click="closeModal">Batal</RedButton>
                        </div>
                    </div>
                </form>
            </div>
        </ModalDialog>

        <!-- Edit data Dosen -->
        <ModalDialog :is-open="isEdit" @close="editClose">
            <template v-slot:jdlDialog>Ubah Data Dosen</template>
            <template v-slot:btn>
                <BtnTutup @click="editClose" />
            </template>
            <div class="flex-auto px-2 lg:px-5 py-5 pb-0">
                <form @submit.prevent="updateDosen">
                    <div class="flex flex-wrap mt-3">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="block uppercase text-blueGray-600 text-xs font-bold mb-2 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    NIP
                                </label>
                                <input type="text" placeholder="NIP" class="input-form" v-model="form.nip">
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mt-3">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="block uppercase text-blueGray-600 text-xs font-bold mb-2 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Nama
                                </label>
                                <input type="text" placeholder="Nama" class="input-form" v-model="form.nama">
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mt-3">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="block uppercase text-blueGray-600 text-xs font-bold mb-2 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Telepon
                                </label>
                                <input type="telepon" placeholder="Telepon" class="input-form" v-model="form.telepon">
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mt-3">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="block uppercase text-blueGray-600 text-xs font-bold mb-2 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Alamat
                                </label>
                                <input type="text" placeholder="Alamat" class="input-form" v-model="form.alamat">
                            </div>
                        </div>
                    </div>
                    <div class="rounded-t mb-0 px-6 py-6">
                        <div class="text-center flex justify-end">
                            <BlueButton type="submit" class="mr-2">Simpan</BlueButton>
                            <RedButton @click="editClose">Batal</RedButton>
                        </div>
                    </div>
                </form>
            </div>
        </ModalDialog>
        <!-- End Tambah data Dosen -->
    </Sidebar>
</template>