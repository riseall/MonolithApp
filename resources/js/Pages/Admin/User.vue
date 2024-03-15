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
    const selectedUser = user.value.find((item) => {
        return item.id === id
    })
    form.value.id = selectedUser?.id ?? '-'
    form.value.name = selectedUser?.name ?? ''
    form.value.email = selectedUser?.email ?? ''
    form.value.password = selectedUser?.password ?? ''
    form.value.role = selectedUser?.role ?? ''
}

const editClose = () => {
    isEdit.value = false
    form.value =
    {
        id: '',
        name: '',
        email: '',
        password: '',
        role: ''
    };
}

const itemsPerPage = 5;
const currentPage = ref(1);

type User = {
    id: string,
    name: string,
    email: string,
    password: string,
    role: string
}

//Get User
const user = ref<User[]>([]);
const getUser = async () => {
    await axios.get('api/user', { params: { keywords: keywords.value } })
        .then(res => {
            console.log(res)
            user.value = res.data.data
        });
};

//handle search item
const keywords = ref(null);
const results = ref<User[]>([]);

watch(keywords, () => {
    getUser();
})

const totalItems = computed(() => user.value.length);
const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage));

const disUser = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    return user.value.slice(startIndex, endIndex);
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

//Post data user
const form: Ref<User> = ref({
    id: '',
    name: '',
    email: '',
    password: '',
    role: ''
});

const createUser = async () => {
    await axios.post('api/user', form.value)
        .then(res => {
            console.log(res);
            // response sukses
            Swal.fire({
                title: "Yeayy!",
                text: "Berhasil Menambahkan Data.",
                icon: "success"
            });
            isOpen.value = false;
            getUser()
            form.value =
            {
                id: '',
                name: '',
                email: '',
                password: '',
                role: ''
            };
        })
        .catch(error => {
            if (error instanceof AxiosError) {
                errors.value = error.response?.data.errors;
            }
            console.error('Post gagal:', error);
        })
}

const updateUser = async () => {
    await axios.put(`api/user/${form.value.id}`, form.value)
        .then(res => {
            console.log(res)
            // response sukses
            Swal.fire({
                title: "Yeayy!",
                text: "Berhasil Mengubah Data.",
                icon: "success"
            });
            isEdit.value = false;
            getUser()
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
                axios.delete(`api/user/${id}`);
                getUser();
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
    getUser();
})
</script>
<template>
    <Head title="User" />

    <Sidebar>
        <div class="block bg-white border border-gray-100 shadow-md shadow-black/5 rounded-lg p-6 overflow-auto">
            <div class="flex mb-4 items-start-start">
                <h3 class="text-lg font-semibold text-left">Data User</h3>
            </div>
            <div class="flex justify-between mb-4 items-start-start">
                <div>
                    <input type="text" class="rounded-lg text-xs p-[0.3 rem]" v-model="keywords" placeholder="Search">
                    <ul v-if="results.length > 0">
                        <li v-for="result in results" :key="result.id" v-text="result.name, result.email, result.role"></li>
                    </ul>
                </div>
                <BlueButton @click="openModal">Tambah Data</BlueButton>
            </div>
            <div class="overflow-x-auto rounded-lg">
                <!-- Table User -->
                <table class="w-full align-middle border border-collapse">
                    <thead class="text-left text-gray-100 bg-gray-700 sticky top-0 rounded-lg">
                        <tr class="table-row">
                            <th class="th-items">No</th>
                            <th class="th-items">Nama</th>
                            <th class="th-items">Email</th>
                            <th class="th-items">Role</th>
                            <th class="th-items">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="odd:bg-gray-50" v-for="(Item, index) in disUser" :key="Item.id">
                            <td class="td-items">{{ (currentPage - 1) * itemsPerPage + index + 1 }}.</td>
                            <td class="td-items">{{ Item.name }}</td>
                            <td class="td-items">{{ Item.email }}</td>
                            <td class="td-items">{{ Item.role }}</td>
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
                <!-- End Table Mahasiswa -->
            </div>
        </div>

        <!-- Tambah data User -->
        <ModalDialog :is-open="isOpen" @close="closeModal">
            <template v-slot:jdlDialog>Tambah Data User</template>
            <template v-slot:btn>
                <BtnTutup @click="closeModal" />
            </template>
            <div class="flex-auto px-2 lg:px-5 py-5 pb-0">
                <form @submit.prevent="createUser">
                    <div class="flex flex-wrap mt-3">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="block uppercase text-blueGray-600 text-xs font-bold mb-2 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Nama
                                </label>
                                <input type="text" placeholder="Nama" class="input-form" v-model="form.name">
                                <div class="text-red-400 text-sm" v-if="errors?.name">{{ errors.name[0] }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mt-3">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="block uppercase text-blueGray-600 text-xs font-bold mb-2 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Email
                                </label>
                                <input type="email" placeholder="Email" class="input-form" v-model="form.email">
                                <div class="text-red-400 text-sm" v-if="errors?.email">{{ errors.email[0] }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mt-3">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="block uppercase text-blueGray-600 text-xs font-bold mb-2 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Password
                                </label>
                                <input type="text" placeholder="Password" class="input-form" v-model="form.password">
                                <div class="text-red-400 text-sm" v-if="errors?.password">{{ errors.password[0] }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mt-3">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="block uppercase text-blueGray-600 text-xs font-bold mb-2 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Role
                                </label>
                                <select name="role" id="role" class="input-form" v-model="form.role">
                                    <option value="">Pilih level user</option>
                                    <option value="admin">Admin</option>
                                    <option value="dosen">Dosen</option>
                                    <option value="mahasiswa">Mahasiswa</option>
                                </select>
                                <div class="text-red-400 text-sm" v-if="errors?.role">{{ errors.role[0] }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-t mb-0 px-6 py-6">
                        <div class="text-center flex justify-end">
                            <BlueButton @click="createUser, closeModal" type="submit" class="mr-2">Simpan</BlueButton>
                            <RedButton @click="closeModal">Batal</RedButton>
                        </div>
                    </div>
                </form>
            </div>
        </ModalDialog>

        <!-- Edit data User -->
        <ModalDialog :is-open="isEdit" @close="editClose">
            <template v-slot:jdlDialog>Ubah Data User</template>
            <template v-slot:btn>
                <BtnTutup @click="editClose" />
            </template>
            <div class="flex-auto px-2 lg:px-5 py-5 pb-0">
                <form @submit.prevent="updateUser">
                    <div class="flex flex-wrap mt-3">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="block uppercase text-blueGray-600 text-xs font-bold mb-2 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Nama
                                </label>
                                <input type="text" placeholder="Nama" class="input-form" v-model="form.name">
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mt-3">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="block uppercase text-blueGray-600 text-xs font-bold mb-2 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Email
                                </label>
                                <input type="email" placeholder="Email" class="input-form" v-model="form.email">
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mt-3">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="block uppercase text-blueGray-600 text-xs font-bold mb-2 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Password
                                </label>
                                <input type="text" placeholder="Password" class="input-form" v-model="form.password">
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mt-3">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="block uppercase text-blueGray-600 text-xs font-bold mb-2 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Role
                                </label>
                                <select name="role" id="role" class="input-form" v-model="form.role">
                                    <option value="">Pilih level user</option>
                                    <option value="admin">Admin</option>
                                    <option value="dosen">Dosen</option>
                                    <option value="mahasiswa">Mahasiswa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-t mb-0 px-6 py-6">
                        <div class="text-center flex justify-end">
                            <BlueButton @click="updateUser" type="submit" class="mr-2">Simpan</BlueButton>
                            <RedButton @click="editClose">Batal</RedButton>
                        </div>
                    </div>
                </form>
            </div>
        </ModalDialog>
        <!-- End Tambah data User -->
    </Sidebar>
</template>