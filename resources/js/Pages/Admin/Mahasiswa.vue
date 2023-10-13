<script setup lang="ts">
import Sidebar from '@/Components/Sidebar.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';
import BlueButton from '@/Components/UI/BlueButton.vue';
import RedButton from '@/Components/UI/RedButton.vue';
import ConfirmDialog from '@/Components/UI/ConfirmDialog.vue';

import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'

const isOpen = ref(true)

function closeModal() {
    isOpen.value = false
}
function openModal() {
    isOpen.value = true
}

type Response = {
    message: string,
    data: Mahasiswa[]
}

type Mahasiswa = {
    id: number,
    foto: string,
    nama: string,
    nim: number,
    kelas: string,
    telepom: number,
    email: string,
    alamat: string
}

const mahasiswa = ref();
axios.get<Response>('api/mahasiswa')
    .then(result => {
        console.log(result)
        mahasiswa.value = result.data.data
    })

const tambahData = ref(false);

function add() {
    tambahData.value = !tambahData.value
}

const isConfirmDialog = ref(false);
</script>
<template>
    <Head title="Mahasiswa" />

    <Sidebar>
        <div class="container block bg-white border border-gray-100 shadow-md shadow-black/5 rounded-lg p-6 overflow-auto">
            <div class="flex justify-between mb-4 items-start-start">
                <h3 class="text-xl font-bold text-left">Data Mahasiswa</h3>
                <BlueButton @click="openModal">Tambah Data</BlueButton>
            </div>
            <div class="container overflow-x-auto rounded-lg">
                <!-- Table Mahasiswa -->
                <table class="w-full align-middle border border-collapse">
                    <thead class="text-left text-slate-800 bg-gray-100 sticky top-0 rounded-lg">
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
                        <tr class="even:bg-gray-50" v-for="(Item, index) in mahasiswa" :key="Item.id">
                            <td class="td-items">{{ index + 1 }}</td>
                            <td class="td-items">
                                <img :src="Item.foto" alt="" class="w-14 h-14 rounded-lg">
                            </td>
                            <td class="td-items">{{ Item.nama }}</td>
                            <td class="td-items">{{ Item.nim }}</td>
                            <td class="td-items">{{ Item.kelas }}</td>
                            <td class="td-items">{{ Item.telepon }}</td>
                            <td class="td-items">{{ Item.email }}</td>
                            <td class="td-items">{{ Item.alamat }}</td>
                            <td class="p-3 text-white">
                                <div class="flex items-center space-x-2">
                                    <button
                                        class="flex items-center justify-center rounded-lg w-8 h-8 bg-green-500 hover:bg-green-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </button>
                                    <button @click="Item.delete"
                                        class="flex items-center justify-center rounded-lg w-8 h-8 bg-rose-500 hover:bg-rose-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- End Table Mahasiswa -->
            </div>
        </div>

        <!-- Dialog Tambah Data -->
        <TransitionRoot appear :show="isOpen" as="template">
            <Dialog as="div" @close="closeModal" class="relative z-10">
                <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100"
                    leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-black bg-opacity-25" />
                </TransitionChild>

                <div class="fixed inset-0 overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4 text-center">
                        <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95">
                            <DialogPanel
                                class="w-full lg:max-w-3xl md:max-w-lg sm:max-w-md transform overflow-hidden rounded-2xl bg-gray-100 p-6 text-left align-middle shadow-xl transition-all">
                                <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                                    Tambah Data Mahasiswa
                                </DialogTitle>
                                <div class="flex-auto px-4 lg:px-10 py-10">
                                    <form>
                                        <div class="flex flex-wrap mt-3">
                                            <div class="w-full lg:w-6/12 px-4">
                                                <div class="relative w-full mb-3">
                                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">
                                                        Nama
                                                    </label>
                                                    <input type="text"
                                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                                                </div>
                                            </div>
                                            <div class="w-full lg:w-6/12 px-4">
                                                <div class="relative w-full mb-3">
                                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">
                                                        NIM
                                                    </label>
                                                    <input type="text"
                                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                                                </div>
                                            </div>
                                            <div class="w-full lg:w-6/12 px-4">
                                                <div class="relative w-full mb-3">
                                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">
                                                        Kelas
                                                    </label>
                                                    <input type="text"
                                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                                                </div>
                                            </div>
                                            <div class="w-full lg:w-6/12 px-4">
                                                <div class="relative w-full mb-3">
                                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">
                                                        Telepon
                                                    </label>
                                                    <input type="text"
                                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                                                </div>
                                            </div>
                                            <div class="w-full lg:w-6/12 px-4">
                                                <div class="relative w-full mb-3">
                                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">
                                                        Email
                                                    </label>
                                                    <input type="email"
                                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="mt-6 border-b-1 border-blueGray-300" />

                                        <div class="flex flex-wrap mt-5">
                                            <div class="w-full lg:w-12/12 px-4">
                                                <div class="relative w-full mb-3">
                                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                                        htmlFor="grid-password">
                                                        Foto
                                                    </label>
                                                    <input type="file"
                                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="mt-6 border-b-1 border-blueGray-300" />

                                        <div class="flex flex-wrap mt-5">
                                            <div class="w-full lg:w-12/12 px-4">
                                                <div class="relative w-full mb-3">
                                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">
                                                        Alamat
                                                    </label>
                                                    <textarea type="text"
                                                        class="border-0 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="rounded-t mb-0 px-6 py-6">
                                            <div class="text-center flex justify-end">
                                                <BlueButton class="mr-2">Simpan</BlueButton>
                                                <RedButton @click="closeModal">Batal</RedButton>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="mt-4">

                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
        <div v-show="tambahData"
            class="container flex flex-col max-w-3xl break-words mb-6 shadow-lg rounded-lg bg-white border-0">
        </div>
        <!-- End dialog tambah data -->

        <ConfirmDialog v-if="isConfirmDialog">
            <template v-slot:title>Konfirmasi</template>
            <template v-slot:message>Apakah anda yakin akan menghapus data?</template>
            <template v-slot:button>
                <RedButton class="mx-1 mr-2">Ya</RedButton>
                <BlueButton>Batal</BlueButton>
            </template>
        </ConfirmDialog>
    </Sidebar>
</template>
<style>
.th-items {
    @apply p-2 text-[13px] font-medium border
}

.td-items {
    @apply p-3 text-gray-600 text-sm font-normal ml-2 truncate
}
</style>