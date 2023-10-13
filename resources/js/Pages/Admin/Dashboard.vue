<script setup lang="ts">
import Sidebar from '@/Components/Sidebar.vue';
import { Head } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Dashboard" />
    <Sidebar>
        <div class="grid lg:grid-cols-4 gap-4 relative md:grid-cols-2">
            <div id="card"
                class="flex flex-row items-center justify-between bg-white p-4 border shadow-md shadow-slate-200 rounded-lg">
                <div>
                    <p class="font-bold">0</p>
                    <p class="text-sm">Absen Masuk</p>
                </div>
                <div class="bg-green-300 text-green-700 p-2 m-2 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd"
                            d="M5.625 1.5H9a3.75 3.75 0 013.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 013.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 01-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875zm5.845 17.03a.75.75 0 001.06 0l3-3a.75.75 0 10-1.06-1.06l-1.72 1.72V12a.75.75 0 00-1.5 0v4.19l-1.72-1.72a.75.75 0 00-1.06 1.06l3 3z"
                            clip-rule="evenodd" />
                        <path
                            d="M14.25 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963A5.23 5.23 0 0016.5 7.5h-1.875a.375.375 0 01-.375-.375V5.25z" />
                    </svg>
                </div>
            </div>
            <div id="card"
                class="flex flex-row items-center justify-between bg-white p-4 border shadow-md shadow-slate-200 rounded-lg">
                <div>
                    <p class="font-bold">0</p>
                    <p class="text-sm">Absen Keluar</p>
                </div>
                <div class="bg-rose-300 text-rose-700 p-2 m-2 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd"
                            d="M5.625 1.5H9a3.75 3.75 0 013.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 013.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 01-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875zm6.905 9.97a.75.75 0 00-1.06 0l-3 3a.75.75 0 101.06 1.06l1.72-1.72V18a.75.75 0 001.5 0v-4.19l1.72 1.72a.75.75 0 101.06-1.06l-3-3z"
                            clip-rule="evenodd" />
                        <path
                            d="M14.25 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963A5.23 5.23 0 0016.5 7.5h-1.875a.375.375 0 01-.375-.375V5.25z" />
                    </svg>
                </div>
            </div>
            <div id="card"
                class="flex flex-row items-center justify-between bg-white p-4 border shadow-md shadow-slate-200 rounded-lg">
                <div>
                    <p class="font-bold">0</p>
                    <p class="text-sm">Mahasiswa</p>
                </div>
                <div class="bg-sky-300 text-sky-700 p-2 m-2 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd"
                            d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            <div id="card"
                class="flex flex-row items-center justify-between bg-white p-4 border shadow-md shadow-slate-200 rounded-lg">
                <div>
                    <p class="font-bold">0</p>
                    <p class="text-sm">Perusahaan</p>
                </div>
                <div class="bg-amber-300 text-amber-700 p-2 m-2 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd"
                            d="M4.5 2.25a.75.75 0 000 1.5v16.5h-.75a.75.75 0 000 1.5h16.5a.75.75 0 000-1.5h-.75V3.75a.75.75 0 000-1.5h-15zM9 6a.75.75 0 000 1.5h1.5a.75.75 0 000-1.5H9zm-.75 3.75A.75.75 0 019 9h1.5a.75.75 0 010 1.5H9a.75.75 0 01-.75-.75zM9 12a.75.75 0 000 1.5h1.5a.75.75 0 000-1.5H9zm3.75-5.25A.75.75 0 0113.5 6H15a.75.75 0 010 1.5h-1.5a.75.75 0 01-.75-.75zM13.5 9a.75.75 0 000 1.5H15A.75.75 0 0015 9h-1.5zm-.75 3.75a.75.75 0 01.75-.75H15a.75.75 0 010 1.5h-1.5a.75.75 0 01-.75-.75zM9 19.5v-2.25a.75.75 0 01.75-.75h4.5a.75.75 0 01.75.75v2.25a.75.75 0 01-.75.75h-4.5A.75.75 0 019 19.5z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
        <!-- <div id="card" class="bg-white m-4 p-4 border shadow-lg shadow-slate-200 rounded-lg">
                <p>
                    Lorem ipsum dolor, sit amet consectetur adipisicing
                    elit. Ipsam labore nam, harum repellat delectus voluptas
                    ipsa quos ullam culpa nesciunt possimus minima sapiente
                    in eaque atque nihil quae officia voluptatum.
                </p>
            </div> -->
    </Sidebar>
</template>