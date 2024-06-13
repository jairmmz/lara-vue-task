<template>
    <h2 class="mt-10 mb-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Iniciar sesión</h2>

    <form @submit.prevent="submitLogin" class="space-y-6" autocomplete="off">
        <InputError label="Correo electrónico" :errors="v$.email.$errors">
            <InputBase v-model:value="formUser.email" type="email" /> 
        </InputError>

        <InputError label="Contraseña" :errors="v$.password.$errors">
            <InputBase v-model:value="formUser.password" type="password" /> 
        </InputError>

        <div class="">
            <Button label="Registrarse" :loading="isLoading"></Button>
        </div>
    </form>

    <p class="mt-10 text-center text-sm text-gray-500">
        No tiene una cuenta?
        {{ ' ' }}
        <RouterLink :to="{ name: 'auth.register' }" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Registrate</RouterLink>
    </p>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { RouterLink } from 'vue-router';
import { useVuelidate } from '@vuelidate/core';
import { useLoginUser } from './actions/login';
import { IUserLogin } from '../../interfaces/UserInterface';
import { required, email } from '@vuelidate/validators';
import InputError from '../../components/InputError.vue';
import InputBase from '../../components/InputBase.vue';
import Button from '../../components/Button.vue';

const { isLoading, login } = useLoginUser();

const formUser = ref<IUserLogin>({} as IUserLogin);

const rules = {
    email: { required, email },
    password: { required },
}

const v$ = useVuelidate(rules, formUser.value);

const submitLogin = async () => {
    const response = await v$.value.$validate();
    if (!response) return;
    await login(formUser.value);
    v$.value.$reset();
};
</script>

<style scoped></style>