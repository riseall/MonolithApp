<script setup lang="ts">
import UpdateProfileInformationForm from '@/Pages/User/Partials/UpdateProfileInformationForm.vue';
import { Head, Link } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

defineProps<{
    mustVerifyEmail?: boolean;
    status?: string;
}>();
</script>

<template>
    <Head title="Profile" />

    <div class="h-screen font-montserrat bg-zinc-100">
        <header class="h-14 p-2 flex flex-col justify-end bg-white shadow-lg">
            <div class="flex items-center justify-between">
                <Link href="user.setting" class="flex text-sm text-sky-600 hover:text-sky-400">
                <FontAwesomeIcon icon="fa-solid fa-chevron-left" class="text-lg" />
                </Link>
                <h1 class="flex justify-center flex-grow font-semibold">Profile</h1>
            </div>
        </header>

        <div class="py-8 p-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-md rounded-lg">
                    <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" class="max-w-xl" />
                </div>
            </div>
        </div>
    </div>
</template>
