<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import InputForm from '@/Components/Form/InputForm.vue';
import BlueButton from '@/Components/UI/BlueButton.vue';
import axios, { AxiosError } from 'axios';
import { ref } from 'vue';
import Swal from 'sweetalert2'

const errors = ref();
const form = ref({
    id: '',
    nama: '',
    email: '',
    alamat: ''
})

const post = async () => {
    await axios.post('api/perusahaan', form.value)
        .then(res => {
            console.log(res.data);
            // response sukses
            Swal.fire({
                title: "Yeayy!",
                text: "Berhasil Menambahkan Data.",
                icon: "success"
            });
        })
        .catch(error => {
            if (error instanceof AxiosError) {
                errors.value = error.response?.data.errors;
            }
            console.error('Post gagal:', error);
        })
}
</script>
<template>
    <Head title="Magang" />

    <div class="min-h-screen font-montserrat bg-zinc-100">
        <header class="h-14 p-2 flex flex-col justify-end bg-white shadow-lg">
            <div class="flex items-center justify-between">
                <Link href="user.setting" class="flex text-sm text-sky-600 hover:text-sky-400">
                <FontAwesomeIcon icon="fa-solid fa-chevron-left" class="text-lg" />
                </Link>
                <h1 class="flex justify-center flex-grow font-semibold">Perusahaan</h1>
            </div>
        </header>
        <div class="py-8 p-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-md rounded-lg">
                    <div class="flex justify-center m-2 mb-6">
                        <h1 class="font-bold">Informasi Perusahaan</h1>
                    </div>
                    <form @submit.prevent="post">
                        <div class="flex flex-wrap mt-4">
                            <InputForm>
                                <template v-slot:title>Nama</template>
                                <template v-slot:input>
                                    <input type="text" v-model="form.nama" placeholder="Nama" class="input-form" />
                                </template>
                            </InputForm>

                            <InputForm>
                                <template v-slot:title>Email</template>
                                <template v-slot:input>
                                    <input type="text" v-model="form.email" placeholder="Email" class="input-form" />
                                </template>
                            </InputForm>

                            <InputForm>
                                <template v-slot:title>Alamat</template>
                                <template v-slot:input>
                                    <input type="text" v-model="form.alamat" placeholder="Alamat" class="input-form" />
                                </template>
                            </InputForm>
                        </div>
                        <div class="rounded-t mb-0 px- py-3">
                            <div class="text-center flex justify-end">
                                <BlueButton @click="post" type="submit" class="mr-2">Tambah</BlueButton>
                                <!-- <RedButton @click="closeModal">Batal</RedButton> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
