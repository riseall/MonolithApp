<script setup lang="ts">
import NavbarBottom from '@/Components/User/NavbarBottom.vue';
import { Head, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { Ref, onMounted, ref } from 'vue';
import BlueButton from '@/Components/UI/BlueButton.vue';
import RedButton from '@/Components/UI/RedButton.vue';
import ModalUser from '@/Components/ModalDialog.vue';
import InputForm from '@/Components/Form/InputForm.vue';
import BtnTutup from '@/Components/UI/BtnTutup.vue';
import { AxiosError } from 'axios';
import Swal from 'sweetalert2'

const isOpen = ref(true)
const closeModal = () => (isOpen.value = false)
const errors = ref();
let user_id = usePage().props.auth.user.id.toString();

type Mahasiswa = {
    id: string,
    user_id: string,
    foto: string,
    nama: string,
    nim: string,
    kelas: string,
    telepon: string,
    email: string,
    alamat: string
}
//Handle untuk manambahkan data
const formData: Ref<Mahasiswa> = ref({
    id: '',
    user_id: '',
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

const alertWarning = () => {
    Swal.fire({
        text: "Silahkan Lengkapi Data Anda !!",
        icon: "info"
    });
}

const postData = async (event: Event) => {
    event.preventDefault();

    const form = new FormData();
    form.append('id', user_id);
    form.append('user_id', user_id);
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
            icon: "success",
            showConfirmButton: false,
            timer: 1500
        });
        isOpen.value = false;
        // redirect ke halaman dashboard
        setTimeout(() => {
            window.location.href = "/dashboard";
        }, 1600);
    } catch (error: unknown) {
        // response error
        if (error instanceof AxiosError) {
            errors.value = error.response?.data.errors;
        }
        console.error('Post gagal:', error);
    }
}

onMounted(() => {
    alertWarning()
});
</script>
<template>
    <Head title="Create Mahasiswa" />
    <NavbarBottom>
        <!-- Dialog Tambah Data -->
        <ModalUser :is-open="isOpen">
            <template v-slot:jdlDialog>Tambah Data Mahasiswa</template>
            <template v-slot:btn>
                <!-- <BtnTutup @click="closeModal" /> -->
            </template>
            <div class="flex-auto px-0 pt-5 pb-0">
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

                    <hr class="mb-4 border-b-1 border-gray-200" />

                    <div class="flex flex-wrap">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-gray-900 text-xs font-bold mb-2">
                                    Foto
                                </label>
                                <input type="file" ref="fileInput" @change="handleFileChange"
                                    class="input-form file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" />
                            </div>
                        </div>
                    </div>

                    <hr class="mt-4 border-b-1 border-gray-300" />

                    <div class="flex flex-wrap mt-5">
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="block uppercase text-gray-900 text-xs font-bold mb-2 after:content-['*'] after:ml-0.5 after:text-red-500">
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
                            <BlueButton @click="postData, closeModal" type="submit" class="mr-2">Simpan</BlueButton>
                            <!-- <RedButton @click="closeModal">Batal</RedButton> -->
                        </div>
                    </div>
                </form>
            </div>
        </ModalUser>
        <!-- End dialog tambah data -->
    </NavbarBottom>
</template>