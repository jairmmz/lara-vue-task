import { ref } from 'vue';
import { makeHttpRequest } from '../../../../helpers/makeHttpRequest';
import { showErrorResponse } from '../../../../helpers/utils';
import { IGetMembers } from '../interfaces/MemberInterface';

export function useGetMember() {
    const isLoading = ref(false);
    const query = ref('');
    const memberData = ref<IGetMembers>({} as IGetMembers);

    async function getMembers(page: number = 1, query: string = '') {
        try {
            isLoading.value = true;
            const response = await makeHttpRequest<null, IGetMembers>
            (`member?query=${query}&page=${page}`, 'GET');
            isLoading.value = false;
            memberData.value = response;
        } catch (error: any) {
            isLoading.value = false;
            showErrorResponse(error);
        }
    }

    return { getMembers, memberData, isLoading, query };
}
