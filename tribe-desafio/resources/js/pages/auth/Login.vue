<script setup lang="ts">
import { ref } from 'vue';
import { authService, type LoginData } from '@/services/auth.service';
import Button from 'primevue/button';
import Checkbox from 'primevue/checkbox';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';

const form = ref<LoginData>({
    email: '',
    password: '',
});

const error = ref('');
const loading = ref(false);

const submit = async () => {
    loading.value = true;
    error.value = '';

    try {
        await authService.login(form.value);
        window.location.href = '/dashboard';
    } catch (err: any) {
        error.value = err.response?.data?.error || 'Erro ao fazer login';
    } finally {
        loading.value = false;
    }
};

</script>

<template>
    <div class="bg-surface-50 dark:bg-surface-950 px-6 py-20 md:px-20 lg:px-80">
        <div
            class="bg-surface-0 dark:bg-surface-900 p-8 md:p-12 shadow-sm rounded-2xl w-full max-w-sm mx-auto flex flex-col gap-8">
            <div class="flex flex-col items-center gap-4">
                <div class="flex items-center gap-4">
                    <img src="https://tribemd.com/_image?href=%2F_astro%2Fimg_base_tribe_logo.9SlBSC8C.svg&f=svg" alt="Tribe Logo" class="h-auto w-50 object-contain" />
                </div>
            </div>
            <div class="flex flex-col gap-6 w-full">
                <div class="flex flex-col gap-2 w-full">
                    <label for="email1"
                        class="text-surface-900 dark:text-surface-0 font-medium leading-normal">Email</label>
                    <InputText id="email1" v-model="form.email" type="text" placeholder="Email"
                        class="w-full px-3 py-2 shadow-sm rounded-lg" />
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <label for="password1"
                        class="text-surface-900 dark:text-surface-0 font-medium leading-normal">Senha</label>

                    <Password id="password1" v-model="form.password" placeholder="Senha" :toggleMask="true" :feedback="false"
                        input-class="w-full!" />
                </div>
            </div>
            <div class="flex align-items-center gap-2">
                <Button label="Entrar" icon="pi pi-user" v-on:click="submit()" v-bind:disabled="loading"
                    class="w-full py-2 rounded-lg flex justify-center items-center gap-2">
                    <template #icon>
                        <i class="pi pi-user text-base! leading-normal!" />
                    </template>
                </Button>

                <Button label="Registrar" icon="pi pi-user-plus" severity="secondary"
                    class="w-full py-2 rounded-lg flex justify-center items-center gap-2">
                    <template #icon>
                        <i class="pi pi-user-plus text-base! leading-normal!" />
                    </template>
                </Button>
            </div>
        </div>
    </div>
</template>