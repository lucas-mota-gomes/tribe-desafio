<script setup>
import { ref } from 'vue';
import { authService } from '@/services/auth.service';
import Toast from 'primevue/toast';

const activeItem = ref(0);

const menuItems = [
    { label: 'Dashboard', icon: 'pi-th-large' },
];

const setActiveItem = (index) => {
    activeItem.value = index;
};

const logout = async () => {
    await authService.logout();
    window.location.href = '/login';
};
</script>

<template>
    <div class="resize-container-1 min-h-screen flex flex-col bg-surface-50 dark:bg-surface-950">
        <div
            class="bg-surface-0 dark:bg-surface-900 py-4 px-8 flex items-center justify-between border-b border-surface-200 dark:border-surface-800 relative lg:static gap-8">
            <div class="flex items-center gap-4">
                <img src="https://tribemd.com/_image?href=%2F_astro%2Fimg_base_tribe_logo.9SlBSC8C.svg&f=svg"
                    alt="Tribe Logo" class="h-auto w-30 object-contain" />
            </div>

            <a v-styleclass="{
                selector: '@next',
                enterFromClass: 'hidden',
                leaveToClass: 'hidden',
                hideOnOutsideClick: true,
                resizeSelector: '.resize-container-1',
                hideOnResize: true
            }" class="cursor-pointer block lg:hidden text-surface-700 dark:text-surface-100">
                <i class="pi pi-bars text-xl! leading-normal!" />
            </a>

            <div
                class="hidden lg:flex flex-1 items-center justify-between absolute lg:static w-full bg-surface-0 dark:bg-surface-900 left-0 top-full z-10 shadow lg:shadow-none">
                <div class="flex-1 flex items-center gap-4 px-8 lg:px-4 py-4 lg:py-0 flex-col lg:flex-row">
                    <a v-for="(item, i) in menuItems" :key="i" :class="[
                        'flex items-center gap-2 p-2 rounded-lg cursor-pointer transition-colors duration-150 border w-full lg:w-auto',
                        activeItem === i
                            ? 'bg-surface-100 dark:bg-surface-800 border-surface-200 dark:border-surface-700'
                            : 'border-transparent hover:bg-surface-50 dark:hover:bg-surface-800 hover:border-surface-200 dark:hover:border-surface-700'
                    ]" @click="setActiveItem(i)">
                        <i
                            :class="[`pi ${item.icon} text-base! leading-normal!`, activeItem === i ? 'text-surface-900 dark:text-surface-100' : 'text-surface-500 dark:text-surface-400']" />
                        <span
                            :class="['font-medium', activeItem === i ? 'text-surface-900 dark:text-surface-100' : 'text-surface-600 dark:text-surface-300']">{{
                            item.label }}</span>
                    </a>
                </div>
                <div
                    class="flex items-center justify-between gap-4 px-8 lg:px-0 py-4 lg:py-0 border-t lg:border-t-0 border-surface-200 dark:border-surface-700">
                    <div class="flex items-center gap-4">
                        <a
                            class="flex items-center justify-center p-2 bg-surface-0 dark:bg-surface-800 rounded-lg border border-surface-200 dark:border-surface-700 hover:bg-surface-50 dark:hover:bg-surface-700 cursor-pointer">
                            <i class="pi pi-sign-out text-base! leading-none! text-surface-600 dark:text-surface-300" v-on:click="logout()" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col flex-1">
            <div class="bg-surface-50 dark:bg-surface-950 flex flex-1">
                <div
                    class="flex-1 bg-surface-0 dark:bg-surface-900">
                    <Toast position="top-right" />
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>