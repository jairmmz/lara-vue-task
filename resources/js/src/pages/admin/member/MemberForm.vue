<template>
    <MemberFormHeader :isEdit="isEdit" createdName="Crear miembro" updatedName="Editar miembro" @backPage="backPage" />
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
import { useRouter } from 'vue-router';
import InputError from '../../../components/InputError.vue';
import InputBase from '../../../components/InputBase.vue';
import Button from '../../../components/Button.vue';
import MemberFormHeader from './components/MemberFormHeader.vue';

const { isLoading, createOrUpdate } = useCreateOrUpdateMember();
const { member, isEdit } = storeToRefs(memberStore);
const router = useRouter();

const rules = {
    name: { required },
    email: { required, email }
};

const v$ = useVuelidate(rules, member.value);

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