import { ref } from 'vue';
import { ISingleProjectResponse } from '../interfaces/ProjectDetailInterface';
import { makeHttpRequest } from '../../../../helpers/makeHttpRequest';
import { showErrorResponse } from '../../../../helpers/utils';

export function useGetProjectDetail() {
    const isLoading = ref(false);
    const projectData = ref<ISingleProjectResponse>({} as ISingleProjectResponse);

    async function getProjectDetail(slug: string) {
        try {
            isLoading.value = true;
            const response = await makeHttpRequest<undefined, ISingleProjectResponse>
            (`project/get-project/${slug}`, 'GET');
            isLoading.value = false;
            projectData.value = response;
        } catch (error) {
            isLoading.value = false;
            showErrorResponse(error);
        }
    }

    return { getProjectDetail, projectData, isLoading };
}