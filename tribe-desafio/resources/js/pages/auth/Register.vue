<script setup lang="ts">
import { ref } from 'vue';
import { authService, type RegisterData } from '@/services/auth.service';

const form = ref<RegisterData>({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const error = ref('');
const loading = ref(false);

const submit = async () => {
    loading.value = true;
    error.value = '';
    
    try {
        await authService.register(form.value);
    } catch (err: any) {
        error.value = err.response?.data?.message || 'Erro ao registrar';
    } finally {
        loading.value = false;
    }
};
</script>

<template>
    <div class="min-h-screen flex items-center justify-center">
        <form @submit.prevent="submit" class="w-full max-w-md space-y-4 p-6">
            <h1 class="text-2xl font-bold">Registrar</h1>
            
            <div v-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ error }}
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Nome</label>
                <input 
                    v-model="form.name" 
                    type="text" 
                    required
                    class="w-full px-3 py-2 border rounded"
                />
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input 
                    v-model="form.email" 
                    type="email" 
                    required
                    class="w-full px-3 py-2 border rounded"
                />
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Senha</label>
                <input 
                    v-model="form.password" 
                    type="password" 
                    required
                    class="w-full px-3 py-2 border rounded"
                />
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Confirmar Senha</label>
                <input 
                    v-model="form.password_confirmation" 
                    type="password" 
                    required
                    class="w-full px-3 py-2 border rounded"
                />
            </div>
            
            <button 
                type="submit" 
                :disabled="loading"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 disabled:opacity-50"
            >
                {{ loading ? 'Registrando...' : 'Registrar' }}
            </button>
        </form>
    </div>
</template>