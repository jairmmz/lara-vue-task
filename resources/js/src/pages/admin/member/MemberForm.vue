<template>
    <h2 class="mt-10 mb-10 text-2xl font-bold leading-9 tracking-tight text-gray-900">{{ isEdit ? "Editar miembro" : "Crear nuevo miembro" }}</h2>
    <pre>
        {{ member }}
    </pre>
    <form @submit.prevent="submitRegister" class="space-y-6" autocomplete="off">
        <InputError label="Nombre" :errors="v$.name.$errors">
            <InputBase v-model:value="member.name" type="text" /> 
        </InputError>

        <InputError label="Correo electrónico" :errors="v$.email.$errors">
            <InputBase v-model:value="member.email" type="email" /> 
        </InputError>

        <div class="">
            <Button label="Guardar" :loading="isLoading" />
        </div>
    </form>

</template>

<script setup lang="ts">
import { useVuelidate } from '@vuelidate/core';
import { required, email } from '@vuelidate/validators';
import { useCreateOrUpdateMember } from './actions/createOrUpdateMember';
import { memberStore } from './store/memberStore';
import { storeToRefs } from 'pinia';
import InputError from '../../../components/InputError.vue';
import InputBase from '../../../components/InputBase.vue';
import Button from '../../../components/Button.vue';

const { isLoading, createOrUpdate } = useCreateOrUpdateMember();
const { member, isEdit } = storeToRefs(memberStore);

const rules = {
    name: { required },
    email: { required, email }
};

const v$ = useVuelidate(rules, member.value);

const submitRegister = async () => {
    const response = await v$.value.$validate();
    if (!response) return;
    await createOrUpdate();
    // console.log(isEdit.value);
    
    v$.value.$reset();
};
</script>

<style scoped></style>