<template>
    <!-- Modal -->
    <div v-if="isOpenModal" class="fixed z-50 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white w-1/2 p-4 rounded shadow-md">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold">Añadir tarea</h2>
                    <!-- Close Button -->
                    <button type="button" @click="emit('closeModal')" class="text-gray-700 hover:text-red-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form enctype="multipart/form-data" @submit.prevent="submitTask">
                    <div class="select-members mb-2">
                        <span v-for="member in selectedMembers" :key="member.id" @click="unSelectMember(member.id)">
                            {{ member.name }} <b>X</b>
                        </span>
                    </div>
                    <div class="mb-4 flex items-center">
                        <div class="w-[70%]">
                            <InputError :errors="v$.name.$errors">
                                <InputBase v-model:value="task.name" type="text" placeholder="Nombre de la tarea" />
                            </InputError>
                        </div>
                        <div class="w-[30%] mx-2">
                            <Button type="submit" :loading="isLoading" label="Añadir" />
                        </div>
                    </div>
                    <div class="mb-2">
                        <input type="text" @keydown="searchMember" v-model="query" placeholder="Buscar miembro ..." class="w-full mr-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="font-bold">
                                <th class="py-2 text-left text-xs text-gray-500 uppercase">Nombre</th>
                                <th class="py-2 text-left text-xs text-gray-500 uppercase">Correo</th>
                                <th class="py-2 text-center text-xs text-gray-500 uppercase">Seleccionar</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            <tr v-for="member in members.data.data" :key="member.id">
                                <td class="py-2">{{ member.name }}</td>
                                <td class="py-2">{{ member.email }}</td>
                                <td class="text-center">
                                    <button type="button" @click="selectMember(member)" class="px-2 py-1 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out">Añadir</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import useVuelidate from '@vuelidate/core';
import { IGetMembers } from '../../member/interfaces/MemberInterface';
import { storeToRefs } from 'pinia';
import { taskStore } from '../store/kaban';
import { useCreateTask } from '../actions/createTask';
import { useSelectMember } from '../actions/selectMember';
import { showError } from '../../../../helpers/toastNotification';
import { myDebounce } from '../../../../helpers/utils';
import { required } from '@vuelidate/validators';
import InputBase from '../../../../components/InputBase.vue';
import InputError from '../../../../components/InputError.vue';
import Button from '../../../../components/Button.vue';

const { task } = storeToRefs(taskStore);
const { selectMember, unSelectMember, selectedMembers } = useSelectMember();
const { isLoading, createTask } = useCreateTask();

defineProps<{
    isOpenModal: boolean;
    members: IGetMembers;
}>();

const emit = defineEmits<{
    (event: 'closeModal'): Promise<void>;
    (event: 'refreshKabanBoard'): Promise<void>;
    (event: 'getMembers', page: number, query: string): Promise<void>;
}>();

const rules = {
    name: { required }, // Matches state.lastName
};

const v$ = useVuelidate(rules, task)
const query = ref('');

const submitTask = async () => {
    const result = await v$.value.$validate();
    if (!result) return;

    if (task.value.member_id.length > 0) {
        await createTask();
        task.value.member_id = [];
        task.value.name = '';
        v$.value.$reset();
        selectedMembers.value = [];
        emit('refreshKabanBoard');
    } else {
        showError('Debe seleccionar al menos un miembro');
    }
}

const searchMember = myDebounce(async () => {
    emit('getMembers', 1, query.value);
}, 200);

</script>

<style scoped>
.select-members span {
    padding: 5px;
    border-radius: 4px;
    border: 1px solid gray;
    cursor: pointer;
    margin: 2px;
}
.select-members span b {
    color: red;
}
</style>