<template>
    <ProjectFormHeader :isEdit="isEdit" createdName="Crear proyecto" updatedName="Editar proyecto" @backPage="backPage" />
    <form @submit.prevent="submitRegister" class="space-y-6" autocomplete="off">
        <InputError label="Nombre" :errors="v$.name.$errors">
            <InputBase v-model:value="project.name" type="text" /> 
        </InputError>

        <InputError label="Fecha de inicio" :errors="v$.start_date.$errors">
            <InputBase v-model:value="project.start_date" type="date" /> 
        </InputError>

        <InputError label="Fecha de término" :errors="v$.end_date.$errors">
            <InputBase v-model:value="project.end_date" type="date" /> 
        </InputError>

        <div class="">
            <Button label="Guardar" :loading="isLoading" />
        </div>
    </form>

</template>

<script setup lang="ts">
import { useVuelidate } from '@vuelidate/core';
import { required, email } from '@vuelidate/validators';
import { storeToRefs } from 'pinia';
import { useRouter } from 'vue-router';
import { useCreateOrUpdateProject } from './actions/createProject';
import { projectStore } from './store/projectStore';
import InputError from '../../../components/InputError.vue';
import InputBase from '../../../components/InputBase.vue';
import Button from '../../../components/Button.vue';
import ProjectFormHeader from './components/ProjectFormHeader.vue';

const { isLoading, createOrUpdate } = useCreateOrUpdateProject();
const { project, isEdit } = storeToRefs(projectStore);
const router = useRouter();

const rules = {
    name: { required },
    start_date: { required },
    end_date: { required }
};

const v$ = useVuelidate(rules, project.value);

const submitRegister = async () => {
    const response = await v$.value.$validate();
    if (!response) return;
    await createOrUpdate();

    v$.value.$reset();
};

const backPage = () => {
    router.back();
}
</script>

<style scoped></style>