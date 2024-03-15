<script setup lang="ts">
import Sidebar from '@/Components/Sidebar.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { Ref, computed, ref, watch } from 'vue';
import BlueButton from '@/Components/UI/BlueButton.vue';
import RedButton from '@/Components/UI/RedButton.vue';
import ModalDialog from '@/Components/ModalDialog.vue';
import InputForm from '@/Components/Form/InputForm.vue';
import BtnTutup from '@/Components/UI/BtnTutup.vue';
import BtnEdit from '@/Components/UI/BtnEdit.vue';
import BtnDelete from '@/Components/UI/BtnDelete.vue';
import { onMounted } from 'vue';
import { AxiosError } from 'axios';
import Swal from 'sweetalert2'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

const isOpen = ref(false)
const isEdit = ref(false)

const closeModal = () => (isOpen.value = false)
const openModal = () => {
    isOpen.value = true
    errors.value = '';
}
const editOpen = (id: string) => {
    isEdit.value = true
    const selectedMahasiswa = mahasiswa.value.find((item) => {
        return item.id === id
    })
    formData.value.id = selectedMahasiswa?.id ?? '-'
    formData.value.foto = selectedMahasiswa?.foto ?? ''
    formData.value.nama = selectedMahasiswa?.nama ?? ''
    formData.value.nim = selectedMahasiswa?.nim ?? ''
    formData.value.kelas = selectedMahasiswa?.kelas ?? ''
    formData.value.telepon = selectedMahasiswa?.telepon ?? ''
    formData.value.email = selectedMahasiswa?.email ?? ''
    formData.value.alamat = selectedMahasiswa?.alamat ?? ''

}
const editClose = () => {
    isEdit.value = false
    formData.value = {
        id: '',
        foto: '',
        nama: '',
        nim: '',
        kelas: '',
        telepon: '',
        email: '',
        alamat: ''
    }
}

const errors = ref();
const itemsPerPage = 5;
const currentPage = ref(1);

type Response = {
    message: string,
    data: Mahasiswa[]
}

type Mahasiswa = {
    id: string,
    foto: string,
    nama: string,
    nim: string,
    kelas: string,
    telepon: string,
    email: string,
    alamat: string
}

const mahasiswa = ref<Mahasiswa[]>([]);
//get data mahasiswa
const getMhs = async () => {
    await axios.get<Response>('api/mahasiswa', { params: { keywords: keywords.value } })
        .then(result => {
            console.log(result)
            mahasiswa.value = result.data.data
        });
}
const totalItems = computed(() => mahasiswa.value.length);
const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage));

const displayedItems = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    return mahasiswa.value.slice(startIndex, endIndex);
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
const results = ref<Mahasiswa[]>([]);

watch(keywords, () => {
    getMhs();
})

//Handle untuk manambahkan data
const formData: Ref<Mahasiswa> = ref({
    id: '',
    foto: '',
    nama: '',
    nim: '',
    kelas: '',
    telepon: '',
    email: '',
    alamat: ''
});

const fileInput = ref<HTMLInputElement | null>(null);
let selectedFile: File | null = null;

const handleFileChange = () => {
    if (fileInput.value) {
        selectedFile = fileInput.value.files![0];
    }
}

const postData = async (event: Event) => {
    event.preventDefault();

    const form = new FormData();
    form.append('nama', formData.value.nama);
    form.append('nim', formData.value.nim);
    form.append('kelas', formData.value.kelas);
    form.append('telepon', formData.value.telepon);
    form.append('email', formData.value.email);
    form.append('alamat', formData.value.alamat);
    try {

        if (selectedFile) {
            form.append('foto', selectedFile);
        }

        const response = await axios.post('api/mahasiswa', form, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });
        // response sukses
        console.log('Berhasil Menambahkan Data', response.data);
        Swal.fire({
            title: "Yeayy!",
            text: "Berhasil Menambahkan Data.",
            icon: "success"
        });
        isOpen.value = false;
        formData.value = {
            id: '',
            foto: '',
            nama: '',
            nim: '',
            kelas: '',
            telepon: '',
            email: '',
            alamat: ''
        }
        getMhs()
    } catch (error: unknown) {
        // response error
        if (error instanceof AxiosError) {
            errors.value = error.response?.data.errors;
        }
        console.error('Post gagal:', error);
    }
}

// Function to handle updating Mahasiswa data
const updateData = async () => {
    const form = new FormData();
    form.append('_method', 'PUT');
    form.append('nama', formData.value.nama);
    form.append('nim', formData.value.nim);
    form.append('kelas', formData.value.kelas);
    form.append('telepon', formData.value.telepon);
    form.append('email', formData.value.email);
    form.append('alamat', formData.value.alamat);

    try {
        if (selectedFile) {
            form.append('foto', selectedFile);
        }

        const response = await axios.post(`api/mahasiswa/${formData.value.id}`, form, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        // Handle the update response
        console.log('Berhasil Memperbarui Data', response.data);
        //sweetalert
        Swal.fire({
            title: "Yeayy!",
            text: "Berhasil Memperbarui Data.",
            icon: "success"
        });
        isEdit.value = false;
        formData.value = {
            id: '',
            foto: '',
            nama: '',
            nim: '',
            kelas: '',
            telepon: '',
            email: '',
            alamat: ''
        }
        selectedFile = null;
        getMhs();
        // You may also need to update the `mahasiswa` list if you're maintaining a list of students
    } catch (error) {
        console.error('Update gagal:', error);
    }
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
                const response = axios.delete(`api/mahasiswa/${id}`);
                getMhs();
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
    getMhs()
});

</script>
<template>
    <Head title="Mahasiswa" />

    <Sidebar>
        <div class="block bg-white border border-gray-100 shadow-md shadow-black/5 rounded-lg p-6 overflow-auto">
            <h3 class="text-lg font-semibold text-left">Data Mahasiswa</h3>
            <div class="flex justify-between mb-4 mt-3 items-start-start">
                <div>
                    <input type="text" class="rounded-lg text-xs p-[0.3 rem]" v-model="keywords" placeholder="Search">
                    <ul v-if="results.length > 0">
                        <li v-for="result in results" :key="result.id" v-text="result.nama, result.nim, result.kelas"></li>
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
                            <th class="th-items">Foto</th>
                            <th class="th-items">Nama</th>
                            <th class="th-items">NIM</th>
                            <th class="th-items">Kelas</th>
                            <th class="th-items">Telepon</th>
                            <th class="th-items">Email</th>
                            <th class="th-items">Alamat</th>
                            <th class="th-items">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="odd:bg-gray-50" v-for="(Item, index) in displayedItems" :key="Item.id">
                            <td class="td-items">{{ (currentPage - 1) * itemsPerPage + index + 1 }}.</td>
                            <td class="td-items">
                                <img :src="Item.foto ?? `/foto_mahasiswa/pas_foto_kosong.png`"
                                    class="w-14 h-14 rounded-xl object-contain">
                            </td>
                            <td class="td-items">{{ Item.nama }}</td>
                            <td class="td-items">{{ Item.nim }}</td>
                            <td class="td-items">{{ Item.kelas }}</td>
                            <td class="td-items">{{ Item.telepon }}</td>
                            <td class="td-items">{{ Item.email }}</td>
                            <td class="td-items">{{ Item.alamat }}</td>
                            <td class="p-3 text-white">
                                <div class="flex items-center space-x-2">
                                    <BtnEdit @click="editOpen(Item.id)" />
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


                <!-- End Table Mahasiswa -->
            </div>
        </div>

        <!-- Dialog Tambah Data -->
        <ModalDialog :is-open="isOpen" @close="closeModal">
            <template v-slot:jdlDialog>Tambah Data Mahasiswa</template>
            <template v-slot:btn>
                <BtnTutup @click="closeModal" />
            </template>
            <div class="flex-auto px-4 lg:px-10 py-10 pb-0">
                <form @submit.prevent="postData">
                    <div class="flex flex-wrap mt-3">
                        <InputForm>
                            <template v-slot:title>Nama</template>
                            <template v-slot:input>
                                <input type="text" v-model="formData.nama" placeholder="Nama" class="input-form" />
                                <div class="text-red-400 text-sm" v-if="errors?.nama">{{ errors.nama[0] }}</div>
                            </template>
                        </InputForm>

                        <InputForm>
                            <template v-slot:title>NIM</template>
                            <template v-slot:input>
                                <input type="text" v-model="formData.nim" placeholder="Nim" class="input-form" />
                                <div class="text-red-400 text-sm" v-if="errors?.nim">{{ errors.nim[0] }}</div>
                            </template>
                        </InputForm>

                        <InputForm>
                            <template v-slot:title>Kelas</template>
                            <template v-slot:input>
                                <input type="text" v-model="formData.kelas" placeholder="Kelas" class="input-form" />
                                <div class="text-red-400 text-sm" v-if="errors?.kelas">{{ errors.kelas[0] }}</div>
                            </template>
                        </InputForm>

                        <InputForm>
                            <template v-slot:title>Telepon</template>
                            <template v-slot:input>
                                <input type="text" v-model="formData.telepon" placeholder="Telepon" class="input-form" />
                                <div class="text-red-400 text-sm" v-if="errors?.telepon">{{ errors.telepon[0] }}</div>
                            </template>
                        </InputForm>

                        <InputForm>
                            <template v-slot:title>Email</template>
                            <template v-slot:input>
                                <input type="email" v-model="formData.email" placeholder="Email"
                                    class="peer invalid:ring-pink-600 input-form" />
                                <div class="text-red-400 text-sm" v-if="errors?.email">{{ errors.email[0] }}</div>
                                <p class="mt-2 invisible peer-invalid:visible text-pink-600 text-sm">
                                    Masukkan alamat email yang valid.
                                </p>
                            </template>
                        </InputForm>
                    </div>

                    <hr class="mt-2 border-b-1 border-blueGray-300" />

                    <div class="flex flex-wrap mt-5">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label class="block text-blueGray-600 text-xs font-bold mb-2">
                                    Foto
                                </label>
                                <input type="file" ref="fileInput" @change="handleFileChange"
                                    class="input-form file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" />
                            </div>
                        </div>
                    </div>

                    <hr class="mt-6 border-b-1 border-blueGray-300" />

                    <div class="flex flex-wrap mt-5">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="block text-blueGray-600 text-xs font-bold mb-2 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Alamat
                                </label>
                                <textarea type="text" v-model="formData.alamat" placeholder="Alamat"
                                    class="input-form"></textarea>
                                <div class="text-red-400 text-sm" v-if="errors?.alamat">{{ errors.alamat[0] }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-t mb-0 px-6 py-6">
                        <div class="text-center flex justify-end">
                            <BlueButton @click="postData" type="submit" class="mr-2">Simpan</BlueButton>
                            <RedButton @click="closeModal">Batal</RedButton>
                        </div>
                    </div>
                </form>
            </div>
        </ModalDialog>
        <!-- End dialog tambah data -->

        <!-- Dialog Edit Data -->
        <ModalDialog :is-open="isEdit">
            <template v-slot:jdlDialog>Edit Data Mahasiswa</template>
            <template v-slot:btn>
                <BtnTutup @click="editClose" />
            </template>
            <div class="flex-auto px-4 lg:px-10 py-10 pb-0">
                <form @submit.prevent="updateData">
                    <div class="flex flex-wrap mt-3">
                        <InputForm>
                            <template v-slot:title>Nama</template>
                            <template v-slot:input>
                                <input type="text" v-model="formData.nama" placeholder="Nama" class="input-form" />
                            </template>
                        </InputForm>

                        <InputForm>
                            <template v-slot:title>NIM</template>
                            <template v-slot:input>
                                <input type="text" v-model="formData.nim" placeholder="Nim" class="input-form" />
                            </template>
                        </InputForm>

                        <InputForm>
                            <template v-slot:title>Kelas</template>
                            <template v-slot:input>
                                <input type="text" v-model="formData.kelas" placeholder="Kelas" class="input-form" />
                            </template>
                        </InputForm>

                        <InputForm>
                            <template v-slot:title>Telepon</template>
                            <template v-slot:input>
                                <input type="text" v-model="formData.telepon" placeholder="Telepon" class="input-form" />
                            </template>
                        </InputForm>

                        <InputForm>
                            <template v-slot:title>Email</template>
                            <template v-slot:input>
                                <input type="email" v-model="formData.email" placeholder="Email"
                                    class="peer invalid:ring-pink-600 input-form" />
                                <p class="mt-2 invisible peer-invalid:visible text-pink-600 text-sm">
                                    Masukkan alamat email yang valid.
                                </p>
                            </template>
                        </InputForm>
                    </div>

                    <hr class="mt-2 border-b-1 border-blueGray-300" />

                    <div class="flex flex-wrap mt-5">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label class="block text-blueGray-600 text-xs font-bold mb-2" htmlFor="grid-password">
                                    Foto
                                </label>
                                <input type="file" ref="fileInput" @change="handleFileChange"
                                    class="input-form file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" />
                            </div>
                        </div>
                    </div>

                    <hr class="mt-6 border-b-1 border-blueGray-300" />

                    <div class="flex flex-wrap mt-5">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label class="block text-blueGray-600 text-xs font-bold mb-2" htmlFor="grid-password">
                                    Alamat
                                </label>
                                <textarea type="text" v-model="formData.alamat" placeholder="Alamat"
                                    class="input-form"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-t mb-0 px-6 py-6">
                        <div class="text-center flex justify-end">
                            <BlueButton @click="updateData" class="mr-2">Simpan</BlueButton>
                            <RedButton @click="editClose">Batal</RedButton>
                        </div>
                    </div>
                </form>
            </div>
        </ModalDialog>
        <!-- End Dialog Edit Data -->
    </Sidebar>
</template>