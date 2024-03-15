<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import InputForm from '@/Components/Form/InputForm.vue';
import BlueButton from '@/Components/UI/BlueButton.vue';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';

const errors = ref();
let user_id = usePage().props.auth.user.id.toString();

const formData = ref({
    id: '',
    mahasiswa_id: '',
    perusahaan_id: '',
    periode: '',
    posisi: '',
    dosen_id: '',
    laporan_id: ''
});

/* //get data mahasiswa magang
const getData = async () => {
    await axios.get(`api/magang/${user_id}`)
        .then(result => {
            console.log(result)
            formData.value = result.data.data
        });
} */

const postData = async (event: Event) => {
    event.preventDefault();

    const form = new FormData();
    form.append('id', user_id);
    form.append('mahasiswa_id', user_id);
    form.append('perusahaan_id', formData.value.perusahaan_id);
    form.append('periode', formData.value.periode);
    form.append('posisi', formData.value.posisi);
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
    } catch (error: unknown) {
        // response error
        console.error('Post gagal:', error);
    }
}

interface Magang {
    nama: string;
    nim: string;
    kelas: string;
    id: number;
    judul_laporan: string;
}

const mahasiswa = ref<Magang | null>(null);
const getMhs = async (id: string) => { const response = await axios.get(`api/mahasiswa/${user_id}`); return response.data.data }

let prs = ref<Magang[]>([]);
const getPrs = () => { axios.get('api/perusahaan').then(res => { prs.value = res.data.data }) }
let dsn = ref<Magang[]>([]);
const getDsn = () => { axios.get('api/dosen').then(res => { dsn.value = res.data.data }) }
let lpr = ref<Magang[]>([]);
const getLpr = () => { axios.get('api/laporan').then(res => { lpr.value = res.data.data }) }

onMounted(async () => {
    mahasiswa.value = await getMhs(user_id);
    getPrs();
    getDsn();
    getLpr();
    /* getData(); */
})
</script>
<template>
    <Head title="Magang" />

    <div class="min-h-screen font-montserrat bg-zinc-100">
        <header class="h-14 p-2 flex flex-col justify-end bg-white shadow-lg">
            <div class="flex items-center justify-between">
                <Link href="user.setting" class="flex text-sm text-sky-600 hover:text-sky-400">
                <FontAwesomeIcon icon="fa-solid fa-chevron-left" class="text-lg" />
                </Link>
                <h1 class="flex justify-center flex-grow font-semibold">Data Magang</h1>
            </div>
        </header>
        <div class="py-8 p-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white/50 dark:bg-gray-800 shadow-md rounded-lg">
                    <form>
                        <div class="flex flex-wrap mt-3" v-if="mahasiswa">
                            <InputForm>
                                <template v-slot:title>Nama</template>
                                <template v-slot:input>
                                    <input type="text" v-model="mahasiswa.nama" class="input-form" readonly />
                                </template>
                            </InputForm>

                            <InputForm>
                                <template v-slot:title>NIM</template>
                                <template v-slot:input>
                                    <input type="text" v-model="mahasiswa.nim" class="input-form" readonly />
                                </template>
                            </InputForm>

                            <InputForm>
                                <template v-slot:title>Kelas</template>
                                <template v-slot:input>
                                    <input type="text" v-model="mahasiswa.kelas" class="input-form" readonly />
                                </template>
                            </InputForm>

                            <InputForm>
                                <template v-slot:title>Perusahaan</template>
                                <template v-slot:input>
                                    <select name="" id="" v-model="formData.perusahaan_id" class="input-form">
                                        <option value="">Masukkan Nama Perusahaan</option>
                                        <option v-for="(M, index) in prs" class="bg-slate-300" :key="index" :value="M.id">{{
                                            M.nama }}</option>
                                    </select>
                                </template>
                            </InputForm>

                            <InputForm>
                                <template v-slot:title>Periode</template>
                                <template v-slot:input>
                                    <input type="text" v-model="formData.periode" placeholder="Periode"
                                        class="input-form" />
                                </template>
                            </InputForm>

                            <InputForm>
                                <template v-slot:title>Posisi</template>
                                <template v-slot:input>
                                    <input type="text" v-model="formData.posisi" placeholder="Posisi" class="input-form" />
                                </template>
                            </InputForm>

                            <InputForm>
                                <template v-slot:title>Judul Laporan</template>
                                <template v-slot:input>
                                    <select name="" id="" v-model="formData.laporan_id" class="input-form">
                                        <option value="">Masukkan Judul Laporan</option>
                                        <option v-for="(M, index) in lpr" class="bg-slate-300" :key="index" :value="M.id">{{
                                            M.judul_laporan }}</option>
                                    </select>
                                </template>
                            </InputForm>
                        </div>

                        <div class="rounded-t mb-0 px-6 py-6">
                            <div class="text-center flex justify-end">
                                <BlueButton @click="postData" class="mr-2">Simpan</BlueButton>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
