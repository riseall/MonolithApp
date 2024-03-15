<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import { GoogleMap, Marker } from 'vue3-google-map'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

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

            center.lat = position.coords.latitude;
            center.lng = position.coords.longitude;
        });
    } else {
        console.error("Geolocation tidak didukung di perangkat ini.");
    }
};

const center = { lat: 0, lng: 0 }

onMounted(() => {
    getLocation();
});

</script>
<template>
    <Head title="Lokasi" />

    <div class="h-screen font-montserrat bg-zinc-200">
        <header class="h-14 p-2 flex flex-col justify-end bg-white shadow-lg">
            <div class="flex items-end justify-between">
                <Link href="user.dashboard" class="flex text-sm text-sky-600 hover:text-sky-400">
                <FontAwesomeIcon icon="fa-solid fa-chevron-left" class="text-lg" />
                </Link>
                <h1 class="flex justify-center flex-grow font-semibold">Lokasi</h1>
            </div>
        </header>

        <main class="m-4">
            <div class="bg-white rounded-lg shadow-lg p-4 border border-gray-300">
                <div class="text-sm text-center pb-3">
                    <h1 class="font-semibold">Lokasi GPS Anda : </h1>
                    <span class="text-xs">{{ latitude }},{{ longitude }}</span>
                </div>
                <GoogleMap api-key="AIzaSyAONJyXFBJ_0w9CXdp6JgtWxtjMlPovaHA" style="width: 100%; height: 500px"
                    :center="center" :zoom="15">
                    <Marker :options="{ position: center }" />
                </GoogleMap>
            </div>
        </main>
    </div>
</template>