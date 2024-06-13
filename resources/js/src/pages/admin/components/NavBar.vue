<template>
    <div class="flex h-screen bg-gray-100">

        <!-- sidebar -->
        <div class="hidden md:flex flex-col w-64 bg-gray-800">
            <div class="flex items-center justify-center h-16 bg-gray-900">
                <span class="text-white font-bold uppercase">{{ userEmail }}</span>
            </div>
            <div class="flex flex-col flex-1 overflow-y-auto">
                <nav class="flex-1 px-2 py-4 bg-gray-800">
                    <ul>
                        <li v-for="item in navigation" :key="item.name">
                            <RouterLink :to="{ name: item.name_route }" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700" exact>
                                <i :class="item.icon"></i>
                                {{ item.name }}
                            </RouterLink>
                        </li>
                        <li>
                            <button @click="emit('logout')" class="flex w-full items-center px-4 py-2 text-gray-100 hover:bg-gray-700">
                                Cerrar sesión
                            </button>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-y-auto">
            <div class="flex items-center justify-between h-16 bg-white border-b border-gray-200">
                <div class="flex items-center px-4">
                    <button class="text-gray-500 focus:outline-none focus:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <input class="mx-4 w-full border rounded-md px-4 py-2" type="text" placeholder="Search">
                </div>
                <div class="flex items-center pr-4">
                    <button
                        class="flex items-center text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19l-7-7 7-7m5 14l7-7-7-7" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="p-4">
                <router-view></router-view>
            </div>
        </div>

    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { RouterLink } from 'vue-router';

type INavigation = {
    name_route: string;
    name: string;
    icon: string;
}

const navigation = ref<INavigation[]>([
    {
        name_route: 'admin',
        name: 'Dashboard',
        icon: 'bi bi-wrench-adjustable'
    },
    {
        name_route: 'projects',
        name: 'Projectos',
        icon: 'bi bi-file-ppt'
    },
    {
        name_route: 'members',
        name: 'Miembros',
        icon: 'bi bi-file-ppt'
    }
]);

const emit = defineEmits<{
    (event: 'logout'): Promise<void>;
}>();

defineProps<{
    userEmail: string | undefined;
}>();
</script>

<style scoped>
a.router-link-active.router-link-exact-active.nav-link {
  color: white;
}

.nav-item .router-link-exact-active {
  border-radius: 5px;
  box-shadow: 1px 1px 5px 1px #69757d;
  background: #2470dc;
  color: #fff;
}
</style>