<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import InputForm from '@/Components/Form/InputForm.vue';
import BlueButton from '@/Components/UI/BlueButton.vue';
import { ref } from 'vue';
import { Ref } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';

let user_id = usePage().props.auth.user.id.toString();

type Laporan = {
    id: string,
    mahasiswa_id: string,
    judul_laporan: string,
    laporan: string,
}

const formData: Ref<Laporan> = ref({
    id: '',
    mahasiswa_id: '',
    judul_laporan: '',
    laporan: ''
})

const fileInput = ref<HTMLInputElement | null>(null);
let selectedFile: File | null = null;

const handleFileChange = () => {
    if (fileInput.value) {
        selectedFile = fileInput.value.files![0];
    }
}

const post = async (event: Event) => {
    event.preventDefault();

    const form = new FormData();
    form.append('id', user_id);
    form.append('mahasiswa_id', user_id);
    form.append('judul_laporan', formData.value.judul_laporan);
    try {

        if (selectedFile) {
            form.append('laporan', selectedFile);
        }

        const response = await axios.post('api/laporan', form, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });
        // response sukses
        console.log('Berhasil Menambahkan Data', response.data);
        Swal.fire({
            title: "Yeayy!",
            text: "Berhasil Menambahkan Data.",
            icon: "success",
            showConfirmButton: false,
            timer: 1500
        });
    } catch (error: unknown) {
        console.error('Post gagal:', error);
    }
}
</script>
<template>
    <Head title="Laporan" />
    <div class="h-screen font-montserrat bg-zinc-100">
        <header class="h-14 p-2 flex flex-col justify-end bg-white shadow-lg">
            <div class="flex items-center justify-between">
                <Link href="user.setting" class="flex text-sm text-sky-600 hover:text-sky-400">
                <FontAwesomeIcon icon="fa-solid fa-chevron-left" class="text-lg" />
                </Link>
                <h1 class="flex justify-center flex-grow font-semibold">Laporan</h1>
            </div>
        </header>
        <div class="py-8 p-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white/50 dark:bg-gray-800 shadow-md rounded-lg">
                    <form @submit.prevent="post">
                        <div class="flex flex-wrap mt-3">
                            <InputForm>
                                <template v-slot:title>Judul Laporan</template>
                                <template v-slot:input>
                                    <input type="text" v-model="formData.judul_laporan" placeholder="Judul Laporan"
                                        class="input-form" />
                                </template>
                            </InputForm>

                            <InputForm>
                                <template v-slot:title>Laporan</template>
                                <template v-slot:input>
                                    <div class="bg-gray-300 border rounded-lg overflow-hidden">
                                        <input type="file" ref="fileInput" @change="handleFileChange"
                                            class="input-form file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" />
                                    </div>
                                </template>
                            </InputForm>
                        </div>
                        <div class="rounded-t mb-0 px-2 py-3">
                            <div class="text-center flex justify-end">
                                <BlueButton @click="post" type="submit" class="mr-2">Simpan</BlueButton>
                                <!-- <RedButton @click="closeModal">Batal</RedButton> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
   

   