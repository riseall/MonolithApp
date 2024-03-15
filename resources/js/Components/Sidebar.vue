<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'

const showDropDown = ref(false);
const showSide = ref(true);

function toggleSidebar() {
    showSide.value = !showSide.value
}

function toggleDrop() {
    showDropDown.value = !showDropDown.value
}
</script>
<template>
    <aside class="relative flex min-h-screen font-montserrat">
        <!-- Sidebar -->
        <div class="bg-gray-900 shadow-lg text-gray-100 w-64 space-y-6 px-2 py-4 md:relative md:-translate-x-0 transform transition duration-200 ease-in-out"
            :class="{ 'relative -translate-x-0': toggleSidebar }" v-show="showSide">
            <Link href="dashboard" class="flex items-center space-x-2 px-4">
            <span class="text-xl font-extrabold text-gray-100">InternshipMonitor</span>
            </Link>
            <nav>
                <ul class="mt-4">
                    <li class="mb-1 group">
                        <Link href="dashboard"
                            class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                        <FontAwesomeIcon icon="fa-solid fa-house-chimney" class="mr-3 text-md" />
                        <span class="text-sm">Dashboard</span>
                        </Link>
                    </li>

                    <Disclosure v-slot="{ open }">
                        <DisclosureButton
                            class="flex w-full items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                            <FontAwesomeIcon icon="fa-solid fa-users" class="mr-3 text-md" />
                            <span class="text-sm">Data Users</span>
                            <FontAwesomeIcon icon="fa-solid fa-chevron-right" class=" text-sm ml-auto"
                                :class="open ? 'rotate-90 transform' : ''" />
                        </DisclosureButton>
                        <DisclosurePanel class="px-8 pt-2 text-sm text-gray-500">
                            <li class="mb-4">
                                <Link href="user"
                                    class="text-gray-300 text-sm flex items-center hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">
                                User</Link>
                            </li>
                            <li class="mb-4">
                                <Link href="mahasiswa"
                                    class="text-gray-300 text-sm flex items-center hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">
                                Mahasiswa
                                </Link>
                            </li>
                            <li class="mb-4">
                                <Link href="dosen"
                                    class="text-gray-300 text-sm flex items-center hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">
                                Dosen</Link>
                            </li>
                        </DisclosurePanel>
                    </Disclosure>
                    <li class="mb-1 group">
                        <Link href="perusahaan"
                            class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                        <FontAwesomeIcon icon="fa-solid fa-building" class="ml-1 mr-3 text-md" />
                        <span class="text-sm">Data Perusahaan</span>
                        </Link>
                    </li>
                    <li class="mb-1 group">
                        <Link href="magang"
                            class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                        <FontAwesomeIcon icon="fa-solid fa-briefcase" class="ml-[2px] mr-3 text-md" />
                        <span class="text-sm">Data Magang</span>
                        </Link>
                    </li>
                    <li class="mb-1 group">
                        <Link href="absensi"
                            class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                        <FontAwesomeIcon icon="fa-solid fa-clipboard" class="ml-1 mr-3 text-md" />
                        <span class="text-sm">Data Absensi</span>
                        </Link>
                    </li>
                    <li class="mb-1 group">
                        <Link href="laporan"
                            class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                        <FontAwesomeIcon icon="fa-solid fa-book" class="ml-1 mr-3 text-md" />
                        <span class="text-sm">Laporan</span>
                        </Link>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- Main content -->
        <div class="flex flex-col w-full h-screen overflow-auto bg-gray-200 ">
            <!-- Header -->
            <div class="bg-white border shadow-lg px-2 py-4 sticky top-0 z-10">
                <div class="bg-white flex items-center justify-between px-5 z-10">
                    <!-- Hamburger Menu -->
                    <button @click="toggleSidebar">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M3 6.75A.75.75 0 013.75 6h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 6.75zM3 12a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 12zm0 5.25a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75a.75.75 0 01-.75-.75z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <!-- User -->
                    <div class="">
                        <div class="flex items-center space-x-4" @click="toggleDrop">
                            <!-- <img class="w-10 h-10 rounded-full border-2 border-gray-50 bg-black" src=""> -->
                            <div class="font-semibold dark:text-white text-left">
                                <span class="inline-flex flex-col rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center border border-transparent text-sm font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                        {{ $page.props.auth.user.name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <span class="text-xs ml-2 text-gray-500 dark:text-gray-400">
                                        {{ $page.props.auth.user.role }}
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div v-show="showDropDown"
                            class="absolute right-[10px] z-10 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg overflow-hidden ring-1 block text-left text-sm leading-5 text-gray-700 dark:text-gray-300">
                            <Link :href="route('profile.edit')" class="drop-item" role="menuitem" tabindex="-1"
                                id="menu-item-0">
                            <div class="space-x-2">
                                <FontAwesomeIcon icon="fa-solid fa-user" class="text-md ml-[0.1rem] text-gray-900" />
                                <span class="text-sm">Profile</span>
                            </div>
                            </Link>
                            <hr>
                            <Link :href="route('logout')" method="post" as="button" class="drop-item" role="menuitem"
                                tabindex="-1" id="menu-item-0">
                            <div class="space-x-2">
                                <FontAwesomeIcon icon="fa-solid fa-arrow-right-from-bracket"
                                    class="text-md ml-[0.1rem] text-rose-700" />
                                <span class="text-sm">LogOut</span>
                            </div>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content -->
            <div class="p-8 min-h-[calc(100vh-(5rem-6px))] max-w-full">
                <slot />
            </div>
        </div>
    </aside>
</template>