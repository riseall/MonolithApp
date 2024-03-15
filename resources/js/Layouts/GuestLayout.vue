<script setup lang="ts">
</script>

<template>
    <div class="bg-gradient-to-t from-gray-400 to-gray-200 min-h-screen flex items-center justify-center font-montserrat ">
        <div
            class="bg-white w-fullS flex rounded-2xl shadow-xl md:max-w-3xl p-5 dark:bg-gray-800 overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
