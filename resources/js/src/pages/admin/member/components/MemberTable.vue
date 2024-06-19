<template>
    <div class="container-fluid">
        <div>
            <input type="text" @keydown="search" v-model="query" placeholder="Buscar miembro ..." class="inline-block mr-2 w-80 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            <span v-show="isLoading">Buscando ...</span>
        </div>
        <div class="container-fluid">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="font-bold">
                        <th class="px-6 py-3 text-left text-xs text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs text-gray-500 uppercase tracking-wider">Correo Electrónico</th>
                        <th class="px-6 py-3 text-left text-xs text-gray-500 uppercase tracking-wider">Acción</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="member in members.data?.data" :key="member.id">
                        <td class="px-6 py-4 whitespace-nowrap">{{ (member.id).substring(0, 7) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ member.name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ member.email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button @click="emit('editMember', member)" class="px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out">Editar</button>
                            <button class="ml-2 px-4 py-2 font-medium text-white bg-red-600 rounded-md hover:bg-red-500 focus:outline-none focus:shadow-outline-red active:bg-red-600 transition duration-150 ease-in-out">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <slot name="pagination"></slot>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { myDebounce } from '../../../../helpers/utils';
import { IGetMembers, IMemberUpdate } from '../interfaces/MemberInterface';

const query = ref<string>('');

defineProps<{
    members: IGetMembers;
    isLoading: boolean;
}>();

const emit = defineEmits<{
    (event: 'editMember', member: IMemberUpdate): void;
    (event: 'getMembers', page: number, query: string): Promise<void>;
}>();


const search = myDebounce(async () => {
    await emit('getMembers', 1, query.value);
}, 200)
</script>

<style scoped>

</style>