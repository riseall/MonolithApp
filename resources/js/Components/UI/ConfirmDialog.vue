<template>
    <div id="dialog" class="absolute bg-white border w-fit shadow-lg rounded-xl px-4 py-3 top-1\2 left-1/3">
        <h3 class="font-bold text-lg my-2">
            <slot name="title" />
        </h3>
        <div id="dialog-msg" class="my-2">
            <slot name="message" />
        </div>
        <div id="dialog-btn" class="my-2">
            <slot name="button" />
        </div>
    </div>
</template>