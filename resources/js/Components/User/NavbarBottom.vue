<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
</script>
<template>
    <div class="min-h-screen bg-gray-100 font-montserrat">
        <div>
            <slot />
        </div>
        <div class="h-20">
            <footer class="flex items-center justify-between fixed bottom-0 left-0 right-0 bg-white text-sm">
                <!-- Link direct Home -->
                <Link href="user.dashboard" class="navbottom ">
                <FontAwesomeIcon icon="fa-solid fa-house-chimney" class="text-3xl text-gray-900" />
                <span class="text-xs mt-1">Home</span>
                </Link>
                <!-- Link direct history -->
                <Link href="user.history" class="navbottom ">
                <FontAwesomeIcon icon="fa-solid fa-clock-rotate-left" class="text-3xl text-gray-900" />
                <span class="text-xs mt-1">History</span>
                </Link>
                <!-- Link direct profile -->
                <Link href="user.setting" class="navbottom ">
                <FontAwesomeIcon icon="fa-solid fa-gear" class="text-3xl text-gray-900" />
                <span class="text-xs mt-1">Setting</span>
                </Link>
            </footer>
        </div>
    </div>
</template>