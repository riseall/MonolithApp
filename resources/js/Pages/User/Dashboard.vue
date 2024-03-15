<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import { format } from 'date-fns';
import { id } from 'date-fns/locale'; // Mengimpor bahasa Indonesia
import NavbarBottom from '@/Components/User/NavbarBottom.vue';
import Lokasi from '@/Components/User/Lokasi.vue';
import ModalDialog from '@/Components/ModalDialog.vue';
import BtnTutup from '@/Components/UI/BtnTutup.vue';
import AmberBtnVue from '@/Components/User/AmberBtn.vue';
import axios from 'axios';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import Swal from 'sweetalert2'

//Logic DateTime
const currentDay = ref('');
const currentDate = ref('');
const currentTime = ref('');

const updateTime = () => {
    const now = new Date();
    currentDay.value = format(now, 'EEEE', { locale: id });
    currentDate.value = format(now, 'd MMMM y', { locale: id });
    currentTime.value = now.toLocaleTimeString();

    setTimeout(updateTime, 1000);
};

//Location
const latitude = ref<number | null>(null);
const longitude = ref<number | null>(null);
const location = ref('');
const apiKey = 'AIzaSyAONJyXFBJ_0w9CXdp6JgtWxtjMlPovaHA';

const getLocation = () => {
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(position => {
            latitude.value = position.coords.latitude;
            longitude.value = position.coords.longitude;

            const googleMapsLink = `https://www.google.com/maps/search/?api=1&query=${latitude.value},${longitude.value}&key=${apiKey}`;
            location.value = googleMapsLink;
        });
    } else {
        console.error("Geolocation tidak didukung di perangkat ini.");
    }
};

//Open and Close Modal
const isOpen = ref(false);
const isClose = ref(false);

const openMasuk = () => { isOpen.value = true; startCapture(); };
const closeMasuk = () => { isOpen.value = false; stopCapture(); };
const openKeluar = () => { isClose.value = true; startCapture(); };
const closeKeluar = () => { isClose.value = false; stopCapture(); };

//WebCam
const video = ref<HTMLVideoElement | null>(null);

const startCapture = async () => {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false })
        video.value!.srcObject = stream;
        video.value!.play();
    } catch (error) {
        console.error(error);
    }
}

const stopCapture = () => {
    if (video.value && video.value.srcObject) {
        const tracks = (video.value.srcObject as MediaStream).getTracks();
        tracks.forEach((track) => track.stop());
    }
};

const takeScreenshot = () => {
    if (video.value) {
        const canvas = document.createElement('canvas');
        canvas.width = video.value.videoWidth;
        canvas.height = video.value.videoHeight;
        const ctx = canvas.getContext('2d');

        if (ctx) {
            ctx.drawImage(video.value, 0, 0, canvas.width, canvas.height);
            const screenshotDataUrl = canvas.toDataURL('image/png');

            sendScreenshot(screenshotDataUrl);
        }
    }
};

const takeScreenshot_out = () => {
    if (video.value) {
        const canvas = document.createElement('canvas');
        canvas.width = video.value.videoWidth;
        canvas.height = video.value.videoHeight;
        const ctx = canvas.getContext('2d');

        if (ctx) {
            ctx.drawImage(video.value, 0, 0, canvas.width, canvas.height);
            const screenshotDataUrl = canvas.toDataURL('image/png');

            sendScreenshot_out(screenshotDataUrl);
        }
    }
};

let user_id = usePage().props.auth.user.id.toString();

const sendScreenshot = async (dataUrl: string) => {
    try {
        // Ubah data URL menjadi blob
        const blob = await fetch(dataUrl).then((res) => res.blob());

        const formData = new FormData();
        formData.append('mahasiswa_id', user_id);
        formData.append('foto', blob, 'png');
        formData.append('hari', currentDay.value);
        formData.append('tanggal', currentDate.value);
        formData.append('waktu', currentTime.value);
        formData.append('lokasi', location.value);

        // Kirim FormData ke server menggunakan Axios
        const response = await axios.post('api/absenMasuk', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            title: "Yeayy! Berhasil Absen Masuk",
            icon: "success"
        });
        closeMasuk();
    } catch (error) {
        console.error('Error uploading screenshot:', error);
    }
};

const sendScreenshot_out = async (dataUrl: string) => {
    try {
        // Ubah data URL menjadi blob
        const blob = await fetch(dataUrl).then((res) => res.blob());

        const formData = new FormData();
        formData.append('mahasiswa_id', user_id);
        formData.append('foto', blob, 'png');
        formData.append('hari', currentDay.value);
        formData.append('tanggal', currentDate.value);
        formData.append('waktu', currentTime.value);
        formData.append('lokasi', location.value);

        // Kirim FormData ke server menggunakan Axios
        const response = await axios.post('api/absenKeluar', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            title: "Yeayy! Berhasil Absen Keluar",
            icon: "success"
        });
        closeKeluar();
    } catch (error) {
        console.error('Error uploading screenshot:', error);
    }
};

const msk = ref({ waktu: '' });
const getMsk = (() => { axios.get('api/masukk').then(res => { msk.value = res.data.data.pop() }) })
const kl = ref({ waktu: '' });
const getKlr = (() => { axios.get('api/keluarr').then(res => { kl.value = res.data.data.pop() }) })

onMounted(() => {
    updateTime();
    getLocation();
    getMsk();
    getKlr();
});

</script>
<template>
    <Head title="Dashboard" />
    <NavbarBottom>
        <div class="bg-gray-800 text-white p-6 overflow-auto">
            <div class="flex items-center justify-between">
                <div>
                    <h1>Halo!!</h1>
                    <span class="text-xl font-bold">{{ $page.props.auth.user.name }}</span>
                </div>
                <span class="text-">{{ currentTime }}</span>
            </div>
            <div
                class=" flex items-center justify-between rounded-lg mt-4 p-4 px-6 bg-gradient-to-br from-amber-500 to-amber-200 ">
                <div class="text-gray-900">
                    <h1 class="font-semibold">{{ currentDay }}</h1>
                    <span class="text-sm">{{ currentDate }}</span>
                </div>

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-10 h-10 text-gray-800/75">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                </svg>
            </div>
        </div>

        <Lokasi />

        <main class="m-4 mt-5">
            <div class="grid gap-5 relative lg:grid-cols-2 md:grid-cols-1">
                <div class="bg-white rounded-md shadow-lg flex p-4 py-5 border border-gray-300">
                    <div class="p-2 rounded-md mr-5 bg-green-100">
                        <FontAwesomeIcon icon="fa-solid fa-arrow-right-to-bracket" class="mr-1 text-lg text-green-700" />
                    </div>
                    <div class="text-sm">
                        <h1 class="font-semibold">Masuk</h1>
                        <span class="text-xs">{{ msk.waktu ?? '-' }}</span>
                    </div>
                </div>
                <div class="bg-white rounded-md shadow-lg flex p-4 py-5 border border-gray-300">
                    <div class="p-2 rounded-md mr-5 bg-rose-100">
                        <FontAwesomeIcon icon="fa-solid fa-arrow-right-from-bracket" class="ml-1 text-lg text-red-700" />
                    </div>
                    <div class="text-sm">
                        <h1 class="font-semibold">Keluar</h1>
                        <span class="text-xs">{{ kl.waktu ?? '-' }}</span>
                    </div>
                </div>
            </div>
            <div class="flex justify-between mt-5 gap-5 font-semibold">
                <AmberBtnVue @click="openMasuk">
                    Absen Masuk
                </AmberBtnVue>
                <AmberBtnVue @click="openKeluar">
                    Absen Keluar
                </AmberBtnVue>
            </div>
        </main>

        <!-- Dialog Untuk Kamera Absen Masuk -->
        <ModalDialog :is-open="isOpen" @close="closeMasuk">
            <template v-slot:btn>
                <BtnTutup @click="closeMasuk" />
            </template>
            <video ref="video" class="mt-3 rounded-lg w-full"></video>
            <AmberBtnVue @click="takeScreenshot" class="mt-3 space-x-3">
                <FontAwesomeIcon icon="fa-solid fa-camera-retro" class="mr-1 text-lg" />
                <span>Ambil</span>
            </AmberBtnVue>
        </ModalDialog>

        <!-- Dialog Untuk Kamera Absen Keluar -->
        <ModalDialog :is-open="isClose">
            <template v-slot:btn>
                <BtnTutup @click="closeKeluar" />
            </template>
            <video ref="video" class="mt-3 rounded-lg"></video>
            <AmberBtnVue @click="takeScreenshot_out" class="mt-3 space-x-3">
                <FontAwesomeIcon icon="fa-solid fa-camera-retro" class="mr-1 text-lg" />
                <span>Ambil</span>
            </AmberBtnVue>
        </ModalDialog>
    </NavbarBottom>
</template>