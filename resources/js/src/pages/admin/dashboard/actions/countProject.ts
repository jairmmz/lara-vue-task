import { ref } from "vue";
import { makeHttpRequest } from "../../../../helpers/makeHttpRequest";
import { showErrorResponse } from "../../../../helpers/utils";

interface ICountProject {
    message: string;
    data: number;
    code: number;
}

export function useGetTotalProject() {
    const countProject = ref<ICountProject>({} as ICountProject);

    async function getTotalProject() {
        try {
            const data = await makeHttpRequest<undefined, ICountProject>
            ('project/count-projects', 'GET');

            countProject.value = data;
            updateDate();
        } catch (error) {
            showErrorResponse(error);
        }
    }

    function updateDate() {
        // window.Echo.channel('countProject')
        // .listen('CreateProjectEvent',
        //     (event: { countProject: number }) => {
        //         countProject.value.data = event.countProject;
        //     }
        // );
    }

    return { countProject, getTotalProject, updateDate };
}