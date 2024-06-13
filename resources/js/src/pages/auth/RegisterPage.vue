<template>
    <h2 class="mt-10 mb-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Crear cuenta</h2>

    <form @submit.prevent="submitRegister" class="space-y-6" autocomplete="off">
        <InputError label="Correo electrónico" :errors="v$.email.$errors">
            <InputBase v-model:value="formUser.email" type="email" /> 
        </InputError>

        <InputError label="Contraseña" :errors="v$.password.$errors">
            <InputBase v-model:value="formUser.password" type="password" /> 
        </InputError>

        <InputError label="Confirmar contraseña" :errors="v$.password_confirmation.$errors">
            <InputBase v-model:value="formUser.password_confirmation" type="password" /> 
        </InputError>

        <div class="">
            <Button label="Registrarse" :loading="isLoading" />
        </div>
    </form>

    <p class="mt-10 text-center text-sm text-gray-500">
        Ya tiene una cuenta?
        {{ ' ' }}
        <RouterLink :to="{ name: 'auth.login' }" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Iniciar sesión</RouterLink>
    </p>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { RouterLink } from 'vue-router';
import { useVuelidate } from '@vuelidate/core';
import { useRegisterUser } from './actions/register';
import { required, email } from '@vuelidate/validators';
import { IUserRegister } from '../../interfaces/UserInterface';
import InputError from '../../components/InputError.vue';
import InputBase from '../../components/InputBase.vue';
import Button from '../../components/Button.vue';

const { isLoading, register } = useRegisterUser();

const formUser = ref<IUserRegister>({} as IUserRegister);

const rules = {
    email: { required, email },
    password: { required },
    password_confirmation: { required }
}

const v$ = useVuelidate(rules, formUser.value);

const submitRegister = async () => {
    const response = await v$.value.$validate();
    if (!response) return;
    await register(formUser.value);
    v$.value.$reset();
};
</script>

<style scoped></style>