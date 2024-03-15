<script setup lang="ts">
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import GoogleIcon from '@/Components/UI/GoogleIcon.vue';

defineProps<{
    canResetPassword?: boolean;
    status?: string;
    canRegister?: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
        <!-- Form -->
        <div class="sm:w-1/2 px-10">
            <h1 class="text-3xl font-bold">Login</h1>
            <p class="text-xs mt-2">If you already a member, easily log in</p>
            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="email" value="Email" class="mt-8" />

                    <TextInput id="email" placeholder="Email" type="email"
                        class="mt-1 block w-full placeholder:text-xs placeholder:text-slate-300" v-model="form.email"
                        required autofocus autocomplete="username" />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password" />

                    <TextInput id="password" placeholder="Password" type="password"
                        class="mt-1 block w-full placeholder:text-xs placeholder:text-slate-300" v-model="form.password"
                        required autocomplete="current-password" />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="block mt-4">
                    <label class="flex items-center group hover:cursor-pointer">
                        <Checkbox name="remember" class="group-hover:cursor-pointer" v-model:checked="form.remember" />
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                    </label>
                </div>

                <button :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    class="w-full mt-4 px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Log in
                </button>
            </form>

            <div class="mt-6 grid grid-cols-3 items-center text-gray-400">
                <hr class="border-gray-400">
                <p class="text-center text-sm">OR</p>
                <hr class="border-gray-400">
            </div>

            <a :href="route('googleAuth')">
                <button
                    class="w-full mt-5 px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <GoogleIcon>Log in With Google</GoogleIcon>
                </button>
            </a>

            <div class="mt-5 text-xs border-b border-[#002D74] py-4 text-[#002D74]">
                <Link :href="route('password.request')"
                    class=" text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none dark:focus:ring-offset-gray-800">
                Forgot your password?
                </Link>
            </div>

            <div
                class="mt-3 text-xs flex justify-between items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none dark:focus:ring-offset-gray-800">
                <p class="hover:cursor-pointer">Don't have an account?</p>
                <Link :href="route('register')"
                    class="py-2 px-5 bg-white text-gray-800 border border-gray-800 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Register
                </Link>
            </div>
        </div>

        <!-- Illustrations -->
        <div class="sm:block items-end hidden w-1/2 bg-gradient-to-b from-gray-700 via-gray-600 to-gray-400 rounded-lg p-5">
            <img src="lrvueprog.svg" class="pt-40">
        </div>
    </GuestLayout>
</template>
