<script setup lang="ts">
import NavbarBottom from '@/Components/User/NavbarBottom.vue';
import { Head, Link } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import DangerButton from '@/Components/DangerButton.vue';
</script>
<template>
    <Head title="Setting" />

    <NavbarBottom>
        <header class="h-14 flex items-end justify-center p-2 bg-white shadow-lg sticky top-0 z-10">
            <h1 class="font-semibold">Setting</h1>
        </header>
        <div class="py-6 p-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <div class="p-2 px-3 hover:bg-gradient-to-b hover:from-zinc-400 hover:to-zinc-100 group">
                        <Link href="user.profile"
                            class="flex justify-between items-center group-hover:scale-95 group-hover:transition group-hover:ease-in-out group-hover:duration-200">
                        <div class="space-x-3">
                            <FontAwesomeIcon icon="fa-solid fa-user" class="text-md ml-[1.5px] text-gray-900" />
                            <span class="text-sm">Profile</span>
                        </div>
                        <FontAwesomeIcon icon="fa-solid fa-chevron-right" class="text-md text-gray-900" />
                        </Link>
                    </div>
                    <hr>
                    <div class="p-2 px-3 hover:bg-gradient-to-b hover:from-zinc-400 hover:to-zinc-100 group">
                        <Link href="user.keamanan"
                            class="flex justify-between items-center group-hover:scale-95 group-hover:transition group-hover:ease-in-out group-hover:duration-200">
                        <div class="space-x-3">
                            <FontAwesomeIcon icon="fa-solid fa-shield-halved" class="text-md text-gray-900" />
                            <span class="text-sm">Keamanan</span>
                        </div>
                        <FontAwesomeIcon icon="fa-solid fa-chevron-right" class="text-md text-gray-900" />
                        </Link>
                    </div>
                    <hr>
                    <div class="p-2 px-3 hover:bg-gradient-to-b hover:from-zinc-400 hover:to-zinc-100 group">
                        <Link href="user.perusahaan"
                            class="flex justify-between items-center group-hover:scale-95 group-hover:transition group-hover:ease-in-out group-hover:duration-200">
                        <div class="space-x-3">
                            <FontAwesomeIcon icon="fa-solid fa-building"
                                class="text-md ml-[1.6px] mr-[2px] text-gray-900" />
                            <span class="text-sm">Perusahaan</span>
                        </div>
                        <FontAwesomeIcon icon="fa-solid fa-chevron-right" class="text-md text-gray-900" />
                        </Link>
                    </div>
                    <hr>
                    <div class="p-2 px-3 hover:bg-gradient-to-b hover:from-zinc-400 hover:to-zinc-100 group">
                        <Link href="user.magang"
                            class="flex justify-between items-center group-hover:scale-95 group-hover:transition group-hover:ease-in-out group-hover:duration-200">
                        <div class="space-x-3">
                            <FontAwesomeIcon icon="fa-solid fa-briefcase" class="text-md text-gray-900" />
                            <span class="text-sm">Data Magang</span>
                        </div>
                        <FontAwesomeIcon icon="fa-solid fa-chevron-right" class="text-md text-gray-900" />
                        </Link>
                    </div>
                    <hr>
                    <div class="p-2 px-3 hover:bg-gradient-to-b hover:from-zinc-400 hover:to-zinc-100 group">
                        <Link href="user.laporan"
                            class="flex justify-between items-center group-hover:scale-95 group-hover:transition group-hover:ease-in-out group-hover:duration-200">
                        <div class="space-x-3">
                            <FontAwesomeIcon icon="fa-solid fa-book" class="text-md ml-[1.5px] text-gray-900" />
                            <span class="text-sm">Laporan</span>
                        </div>
                        <FontAwesomeIcon icon="fa-solid fa-chevron-right" class="text-md text-gray-900" />
                        </Link>
                    </div>
                </div>
                <Link :href="route('logout')" method="post" as="button"
                    class="w-full border-2 border-zinc-500 dark:bg-gray-800 shadow rounded-lg">
                <DangerButton class="w-full justify-center">
                    Logout
                </DangerButton>
                </Link>
            </div>
        </div>
    </NavbarBottom>
</template>