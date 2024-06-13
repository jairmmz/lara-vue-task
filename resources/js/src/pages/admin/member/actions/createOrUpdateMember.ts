import { ref } from 'vue';
import { IMember, IMemberResponse } from '../interfaces/MemberInterface';
import { showError, showSuccess } from '../../../../helpers/toastNotification';
import { makeHttpRequest } from '../../../../helpers/makeHttpRequest';
import { storeToRefs } from 'pinia';
import { memberStore } from '../store/memberStore';
import { showErrorResponse } from '../../../../helpers/utils';

const { member, isEdit } = storeToRefs(memberStore);

export function useCreateOrUpdateMember() {
    const isLoading = ref(false);

    async function createOrUpdate() {
        try {
            isLoading.value = true;
            const response = isEdit.value ? await update() : await create();
            showSuccess(response.message);
            member.value = {} as IMember;
        } catch (error: any) {
            isLoading.value = false;
            showErrorResponse(error);
        }
    }

    return { createOrUpdate, isLoading };
}

async function create() {
    const data = await makeHttpRequest<IMember, IMemberResponse>
    ('member/save', 'POST', member.value);

    return data;
}

async function update() {
    const data = await makeHttpRequest<IMember, IMemberResponse>
    (`member/update/${member.value.id}`, 'PUT', member.value);
    isEdit.value = false;

    return data;
}