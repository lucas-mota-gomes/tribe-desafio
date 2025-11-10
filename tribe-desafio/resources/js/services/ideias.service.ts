import { edit } from '@/routes/profile';
import axios from 'axios';

const api = axios.create({
    baseURL: '/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
});

api.interceptors.request.use((config) => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

export interface Ideia {
    id: number;
    titulo: string;
    descricao: string;
}

export const ideiasService = {
    async create(ideia: Omit<Ideia, 'id'>): Promise<Ideia> {
        const response = await api.post<Ideia>('/ideias', ideia);
        console.log("🚀 ~ response:", response)
        return response.data;
    },
    async getAll(): Promise<Ideia[]> {
        const response = await api.get<Ideia[]>('/ideias');
        return response.data;
    },  
    async vote(ideiaId: number, tipo: 'positivo' | 'negativo'): Promise<void> {
        await api.post(`/ideias/${ideiaId}/votar`, { tipo });
    },
    async update(ideiaId: number, ideia: Partial<Omit<Ideia, 'id'>>): Promise<Ideia> {
        const response = await api.put<Ideia>(`/ideias/${ideiaId}`, ideia);
        return response.data;
    },
    async delete(ideiaId: number): Promise<void> {
        await api.delete(`/ideias/${ideiaId}`);
    }
};
