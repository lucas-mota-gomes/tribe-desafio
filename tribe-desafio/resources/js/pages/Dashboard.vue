<template>
    <div class="bg-surface-50 dark:bg-surface-950 px-6 py-20 md:px-12 lg:px-20 h-full">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-surface-900 dark:text-surface-0">Ideias</h1>
            <Button label="Nova Ideia" icon="pi pi-plus" @click="abrirDialog" severity="primary" />
        </div>

        <div v-if="carregando" class="flex justify-center items-center py-20">
            <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="4" fill="transparent" animationDuration="1s"
                aria-label="Carregando ideias" />
        </div>

        <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <Card v-for="ideia in ideias" :key="ideia.id"
                class="bg-surface-0 dark:bg-surface-900 shadow-sm rounded-2xl">
                <template #title>
                    <span class="font-medium text-surface-900 dark:text-surface-0 text-xl leading-tight">
                        {{ ideia.titulo }}
                    </span>
                </template>

                <template #subtitle>
                    <div class="flex items-center gap-2 text-surface-600 dark:text-surface-200">
                        <i class="pi pi-user text-sm"></i>
                        <span class="font-normal leading-tight">{{ ideia.autor }}</span>
                    </div>
                </template>

                <template #content>
                    <div class="flex flex-col gap-4">
                        <p class="text-surface-600 dark:text-surface-300 leading-relaxed line-clamp-3">
                            {{ ideia.descricao }}
                        </p>
                    </div>
                </template>

                <template #footer>
                    <div class="flex gap-3 justify-between items-center">

                        <div class="flex items-center gap-2 text-sm text-surface-500 dark:text-surface-400">
                            <i class="pi pi-calendar"></i>
                            <span>{{ formatarData(ideia.criado_em) }}</span>
                        </div>
                        <div class="flex gap-2">
                            <Button type="button" severity="primary" v-on:click="votarIdeia(ideia?.id, 'positivo')" outlined icon="pi pi-thumbs-up"
                                :badge="ideia?.votos?.toString() || '0'" />
                            <Button type="button" severity="danger" v-on:click="votarIdeia(ideia?.id, 'negativo')" outlined icon="pi pi-thumbs-down"
                                :badge="ideia?.votos_negativos?.toString() || '0'" />
                        </div>
                    </div>
                </template>
            </Card>
        </div>

        <Dialog v-model:visible="dialogVisivel" modal header="Nova Ideia" :style="{ width: '32rem' }"
            :breakpoints="{ '960px': '75vw', '641px': '90vw' }">
            <div class="flex flex-col gap-6 py-4">
                <div class="flex flex-col gap-2">
                    <label for="titulo" class="font-semibold text-surface-900 dark:text-surface-0">
                        Título
                    </label>
                    <InputText id="titulo" v-model="novaIdeia.titulo" placeholder="Digite o título da ideia"
                        class="w-full" />
                </div>

                <div class="flex flex-col gap-2">
                    <label for="descricao" class="font-semibold text-surface-900 dark:text-surface-0">
                        Descrição
                    </label>
                    <Textarea id="descricao" v-model="novaIdeia.descricao" rows="5"
                        placeholder="Descreva sua ideia em detalhes" class="w-full" />
                </div>
            </div>

            <template #footer>
                <Button label="Cancelar" severity="secondary" outlined @click="fecharDialog" :disabled="salvando" />
                <Button label="Salvar" icon="pi pi-check" @click="salvarIdeia" :loading="salvando" />
            </template>
        </Dialog>
    </div>
</template>

<script setup>
import Layout from '@/layouts/Layout.vue';
import { ref } from 'vue';
import Card from 'primevue/card';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import ProgressSpinner from 'primevue/progressspinner';
import { ideiasService } from '@/services/ideias.service';
import { useToast } from 'primevue/usetoast';

defineOptions({
    layout: Layout
});

const carregando = ref(false);
const dialogVisivel = ref(false);
const salvando = ref(false);
const toast = useToast();
const ideias = ref([]);




const novaIdeia = ref({
    titulo: '',
    descricao: ''
});

const abrirDialog = () => {
    dialogVisivel.value = true;
};

const fecharDialog = () => {
    dialogVisivel.value = false;
    novaIdeia.value = {
        titulo: '',
        descricao: ''
    };
};

const salvarIdeia = async () => {
    salvando.value = true;

    try {
        const resposta = await ideiasService.create(novaIdeia.value);
        console.log("🚀 ~ salvarIdeia ~ resposta:", resposta)

        ideias.value.unshift({
            id: resposta.id || ideias.value.length + 1,
            titulo: novaIdeia.value.titulo,
            descricao: novaIdeia.value.descricao,
            autor: 'Usuário Atual',
            criado_em: new Date().toISOString(),
            votos: 0
        });

        fecharDialog();

        console.log('Ideia criada com sucesso!');

    } catch (erro) {
        console.error('Erro ao salvar ideia:', erro);

        alert('Erro ao salvar ideia. Tente novamente.');

    } finally {
        salvando.value = false;
    }
};

const votarIdeia = async (ideiaId, tipoVoto) => {
    try {
        await ideiasService.vote(ideiaId, tipoVoto);

        await getIdeias();

    } catch (erro) {
        console.error('Erro ao votar na ideia:', erro);
        alert('Erro ao registrar voto. Tente novamente.');
    }
};

const getIdeias = async () => {
    carregando.value = true;

    try {
        const resposta = await ideiasService.getAll();
        ideias.value = resposta.map(ideia => ({
            id: ideia.id,
            titulo: ideia.titulo,
            descricao: ideia.descricao,
            autor: ideia.autor?.name || 'Desconhecido',
            criado_em: ideia.created_at,
            votos: ideia.votos_positivos || 0,
            votos_negativos: ideia.votos_negativos || 0
        }));
    } catch (erro) {
        console.error('Erro ao carregar ideias:', erro);
        toast.add({ severity: 'error', summary: 'Erro', detail: 'Login expirado. Por favor, faça login novamente.', life: 3000 });
        window.location.href = '/login';
    } finally {
        carregando.value = false;
    }
};


const formatarData = (dataISO) => {
    const data = new Date(dataISO);
    return data.toLocaleDateString('pt-BR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

getIdeias();
</script>

<style scoped>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
