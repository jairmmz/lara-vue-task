<template>
     <NavBar :user-email="userData?.email" @logout="logoutUser"/>
</template>

<script setup lang="ts">
import { getUserData } from '../../helpers/getUserData';
import { useLogoutUser } from './actions/logout';
import NavBar from './components/NavBar.vue';

const { logout } = useLogoutUser();
const userData  = getUserData();

const logoutUser = async () => {
    const userId = userData?.id;
    
    if (typeof userId !== 'undefined') {
        await logout(userId);
        localStorage.clear();
        setTimeout(() => {
            window.location.href = '/login';
        }, 1000);
    }
};

</script>

<style scoped>
</style>