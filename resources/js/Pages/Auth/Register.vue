<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Register" />
        <!-- Form -->
        <div class="sm:w-1/2 px-10">
            <h1 class="text-3xl font-bold">Create Account</h1>
            <span class="text-xs mt-2">Use your email for registration</span>
            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="name" value="Name" class="mt-6" />

                    <TextInput id="name" placeholder="Nama" type="text"
                        class="mt-1 block w-full placeholder:text-xs placeholder:text-slate-300" v-model="form.name"
                        required autofocus autocomplete="name" />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mt-4">
                    <InputLabel for="email" value="Email" />

                    <TextInput id="email" placeholder="Email" type="email"
                        class="mt-1 block w-full placeholder:text-xs placeholder:text-slate-300" v-model="form.email"
                        required autocomplete="username" />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password" />

                    <TextInput id="password" placeholder="Password" type="password"
                        class="mt-1 block w-full placeholder:text-xs placeholder:text-slate-300" v-model="form.password"
                        required autocomplete="new-password" />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password_confirmation" value="Confirm Password" />

                    <TextInput id="password_confirmation" placeholder="Confirm Password" type="password"
                        class="mt-1 block w-full placeholder:text-xs placeholder:text-slate-300"
                        v-model="form.password_confirmation" required autocomplete="new-password" />

                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>

                <button :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    class="w-full mt-4 px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Register
                </button>
            </form>

            <div
                class="mt-5 text-xs flex justify-between items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none dark:focus:ring-offset-gray-800">
                <p class="hover:cursor-pointer">Already registered?</p>
                <Link :href="route('login')"
                    class="py-2 px-5 bg-white text-gray-800 border border-gray-800 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Login
                </Link>
            </div>
        </div>
        <!-- Illustrations -->
        <div class="sm:block items-end hidden w-1/2 bg-gradient-to-b from-gray-700 via-gray-600 to-gray-400 rounded-lg p-5">
            <img src="lrvueprog.svg" class="pt-32">
        </div>
    </GuestLayout>
</template>
