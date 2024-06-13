<template>
    <div class="flex justify-between items-center">
        <h1 class="mb-4 font-bold text-xl">Gestión de Miembros</h1>
        <RouterLink :to="{ name: 'create.member' }"
            class="px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out">
            Crear miembro
        </RouterLink>
    </div>
    <MemberTable @edit-member="editMember" :is-loading="isLoading" @get-members="getMembers" :members="memberData">
    <template #pagination>
            <TailwindPagination v-if="memberData?.data" :data="memberData?.data" @pagination-change-page="getMembers" />
        </template>
    </MemberTable>
</template>

<script setup lang="ts">
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { TailwindPagination } from 'laravel-vue-pagination';
import { useGetMember } from './actions/getMembers';
import MemberTable from './components/MemberTable.vue';
import { IMember } from './interfaces/MemberInterface';
import { memberStore } from './store/memberStore';
import { storeToRefs } from 'pinia';

const { getMembers, isLoading, memberData } = useGetMember();
const { member, isEdit } = storeToRefs(memberStore);

const router = useRouter();

const showListOfMembers = async () => {
    await getMembers();
}

const editMember = (memberEdit: IMember) => {
    member.value = memberEdit;
    isEdit.value = true;
    router.push({ name: 'edit.member', params: { id: memberEdit.id } });
}

onMounted(async () => {
    await showListOfMembers();
    isEdit.value = false;
    member.value = {} as IMember;
});
</script>

<style scoped></style>