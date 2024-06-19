import { ref } from "vue";
import { makeHttpRequest } from "../../../../helpers/makeHttpRequest";
import { showErrorResponse } from "../../../../helpers/utils";
import { IPinnedProject, IPinnedProjectResponse } from "../interfaces/PinnedProjectInterface";

export function useGetPinnedProject() {
    // const isLoading = ref<boolean>(false);
    const project = ref<IPinnedProject>({} as IPinnedProject);

    async function getPinnedProject() {
        try {
            // isLoading.value = true;
            const { data } = await makeHttpRequest<undefined, IPinnedProjectResponse>
            ('project/pinned-projects', 'GET');

            project.value = data;
            // isLoading.value = false;
        } catch (error) {
            showErrorResponse(error);
        }
    }

    return { getPinnedProject, project}
}