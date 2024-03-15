<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>
<template>
    <div class="flex items-center justify-between p-3 py-4 px-5 text-sm bg-gray-700 text-white">
        <div class="flex">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="w-5 h-5 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
            </svg>
            <span>Lokasi</span>
        </div>

        <Link href="user.location" class="flex items-center text-amber-400 font-bold group">
        <span class="group-hover:cursor-pointer group-hover:text-amber-200">Lihat</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
            class="w-4 h-4 group-hover:cursor-pointer group-hover:text-amber-200">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
        </svg>
        </Link>
    </div>
</template>