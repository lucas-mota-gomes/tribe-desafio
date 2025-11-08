<script setup lang="ts">
import { ref } from 'vue';
import { authService, type RegisterData } from '@/services/auth.service';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';

const form = ref<RegisterData>({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const error = ref('');
const loading = ref(false);
const toast = useToast();

const submit = async () => {
    loading.value = true;
    error.value = '';

    try {
        if (form.value.password !== form.value.password_confirmation) {
            toast.add({ severity: 'error', summary: 'Erro', detail: 'As senhas não coincidem.', life: 3000 });
            return;
        }
        await authService.register(form.value);
        toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Registro realizado com sucesso.', life: 3000 });
        window.location.href = '/dashboard';

    } catch (err: any) {
        console.log("🚀 ~ submit ~ err:", err)
        error.value = err.response?.data?.password?.length > 0 ? 'A senha deve ter pelo menos 6 caracteres.' : 'Formato de email inválido ou email já cadastrado.';
        toast.add({ severity: 'error', summary: 'Erro', detail: error.value, life: 3000 });
    } finally {
        loading.value = false;
    }
};
</script>

<template>
    <Toast />
    <div class="bg-surface-50 dark:bg-surface-950 px-6 py-20 md:px-20 lg:px-80">
        <div
            class="bg-surface-0 dark:bg-surface-900 p-8 md:p-12 shadow-sm rounded-2xl w-full max-w-sm mx-auto flex flex-col gap-8">
            <div class="flex flex-col items-center gap-4">
                <div class="flex items-center gap-4">
                    <img src="https://tribemd.com/_image?href=%2F_astro%2Fimg_base_tribe_logo.9SlBSC8C.svg&f=svg"
                        alt="Tribe Logo" class="h-auto w-50 object-contain" />
                </div>
            </div>
            <div class="flex flex-col gap-6 w-full">
                <div class="flex flex-col gap-2 w-full">
                    <label for="name1"
                        class="text-surface-900 dark:text-surface-0 font-medium leading-normal">Nome</label>
                    <InputText id="name1" v-model="form.name" type="text" placeholder="Nome"
                        class="w-full px-3 py-2 shadow-sm rounded-lg" />
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <label for="email1"
                        class="text-surface-900 dark:text-surface-0 font-medium leading-normal">Email</label>
                    <InputText id="email1" v-model="form.email" type="text" placeholder="Email"
                        class="w-full px-3 py-2 shadow-sm rounded-lg" />
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <label for="password1"
                        class="text-surface-900 dark:text-surface-0 font-medium leading-normal">Senha</label>

                    <Password id="password1" v-model="form.password" placeholder="Senha" :toggleMask="true"
                        :feedback="false" input-class="w-full!" />
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <label for="password_confirmation1"
                        class="text-surface-900 dark:text-surface-0 font-medium leading-normal">Confirmar Senha</label>

                    <Password id="password_confirmation1" v-model="form.password_confirmation"
                        placeholder="Confirmar Senha" :toggleMask="true" :feedback="false" input-class="w-full!" />
                </div>
            </div>
            <div class="flex align-items-center gap-2">
                <Button label="Registrar" icon="pi pi-user-plus" v-on:click="submit()" v-bind:disabled="loading"
                    class="w-full py-2 rounded-lg flex justify-center items-center gap-2">
                    <template #icon>
                        <i class="pi pi-user-plus text-base! leading-normal!" />
                    </template>
                </Button>
            </div>
        </div>
    </div>

</template>
