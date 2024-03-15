<script setup lang="ts">
import DeleteUserForm from '@/Pages/User/Partials/DeleteUserForm.vue';
import UpdatePasswordForm from '@/Pages/User/Partials/UpdatePasswordForm.vue';
import { Head, Link } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

defineProps<{
    mustVerifyEmail?: boolean;
    status?: string;
}>();
</script>

<template>
    <Head title="Keamanan" />

    <div class="h-full font-montserrat bg-zinc-200">
        <header class="sticky top-0 z-10 h-14 p-2 flex flex-col justify-end bg-white shadow-lg">
            <div class="flex items-center justify-between">
                <Link href="user.setting" class="flex text-sm text-sky-600 hover:text-sky-400">
                <FontAwesomeIcon icon="fa-solid fa-chevron-left" class="text-lg" />
                </Link>
                <h1 class="flex justify-center flex-grow font-semibold">Keamanan</h1>
            </div>
        </header>

        <div class="py-8 p-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </div>
</template>
