import { storeToRefs } from 'pinia';
import { taskStore } from '../store/kaban';
import { makeHttpRequest } from '../../../../helpers/makeHttpRequest';
import { showSuccess } from '../../../../helpers/toastNotification';
import { showErrorResponse } from '../../../../helpers/utils';

export function useDragTask(fn: (slug: string) => Promise<void>, slug: string) {
    const { currentTaskId } = storeToRefs(taskStore);

    async function fromNotStartedToPending(taskId: string, projectId: string) {
        const notStartedTask = document.querySelector(`.not-started-task-${taskId}`) as HTMLElement;
        const pendingColumn = document.querySelector('.pending-task') as HTMLElement;
        let isDragged = false;

        pendingColumn.addEventListener('dragstart', () => {
            console.log('dragstart');
        })

        // Drag over event: this event fire many actions
        pendingColumn.addEventListener('dragover', (event) => {
            if (!isDragged) {
                event.preventDefault();
                pendingColumn.className += ' hovered';
                isDragged = true;
            }
        });

        pendingColumn.addEventListener('dragleave', () => {
            console.log('dragstart');
            isDragged = false;
            pendingColumn.classList.remove('hovered');
        });

        // Attention drop events fire many actions with in console
        pendingColumn.addEventListener('drop', async (event) => {
            event.preventDefault();
            pendingColumn.append(notStartedTask);
            pendingColumn.classList.remove('hovered');
            isDragged = false;

            // console.log('make httpp...', taskId) sending many actions
            currentTaskId.value = taskId;

            if (!pendingColumn.getAttribute('data-listeners-added')) {
                pendingColumn.setAttribute('data-listeners-added', 'true');

                setTimeout(async () => {
                    await Promise.all([
                        changeTaskStatus(currentTaskId.value, projectId, 'task/not-started-to-pending'),
                        fn(slug)
                    ]);
                    pendingColumn.removeAttribute('data-listeners-added');
                }, 200);
            }
        });
    }

    async function fromPendingToCompleted(taskId: string, projectId: string) {
        const pendingTask = document.querySelector(`.pending-task-${taskId}`) as HTMLElement;
        const completedColumn = document.querySelector('.completed-task') as HTMLElement;
        let isDragged = false;

        completedColumn.addEventListener('dragstart', () => {
            console.log('dragstart');
        });

        // Drag over event: this event fire many actions
        completedColumn.addEventListener('dragover', (event) => {
            if (!isDragged) {
                event.preventDefault();
                completedColumn.className += ' hovered';
                isDragged = true;
            }
        });

        completedColumn.addEventListener('dragleave', () => {
            console.log('dragstart');
            isDragged = false;
            completedColumn.classList.remove('hovered');
        });

        completedColumn.addEventListener('drop', async (event) => {
            event.preventDefault();
            completedColumn.append(pendingTask);
            completedColumn.classList.remove('hovered');
            isDragged = false;

            currentTaskId.value = taskId;

            if (!completedColumn.getAttribute('data-listeners-added')) {
                completedColumn.setAttribute('data-listeners-added', 'true');

                setTimeout(async () => {
                    await Promise.all([
                        changeTaskStatus(currentTaskId.value, projectId, 'task/pending-to-completed'),
                        fn(slug)
                    ]);
                    completedColumn.removeAttribute('data-listeners-added');
                }, 200);
            }
        });
    }

    function fromCompletedToPending(taskId: string, projectId: string) {
        const completedTask = document.querySelector(`.completed-task-${taskId}`) as HTMLElement;
        const pendingColumn = document.querySelector('.pending-task') as HTMLElement;
        let isDragged = false;

        pendingColumn.addEventListener('dragstart', () => {
            console.log('dragstart');
        });

        // Drag over event: this event fire many actions
        pendingColumn.addEventListener('dragover', (event) => {
            if (!isDragged) {
                event.preventDefault();
                pendingColumn.className += ' hovered';
                isDragged = true;
            }
        });

        pendingColumn.addEventListener('dragleave', () => {
            console.log('dragstart');
            isDragged = false;
            pendingColumn.classList.remove('hovered');
        });

        pendingColumn.addEventListener('drop', async (event) => {
            event.preventDefault();
            pendingColumn.append(completedTask);
            pendingColumn.classList.remove('hovered');
            isDragged = false;

            currentTaskId.value = taskId;

            if (!pendingColumn.getAttribute('data-listeners-added')) {
                pendingColumn.setAttribute('data-listeners-added', 'true');

                setTimeout(async () => {
                    await Promise.all([
                        changeTaskStatus(currentTaskId.value, projectId, 'task/completed-to-pending'),
                        fn(slug)
                    ]);
                    pendingColumn.removeAttribute('data-listeners-added');
                }, 200);
            }
        });
    }

    return { fromNotStartedToPending, fromPendingToCompleted, fromCompletedToPending };
}

export type changeTaskInput = {
    task_id: string;
    project_id: string;
}

export async function changeTaskStatus(taskId: string, projectId: string, endPoint: string) {
    try {
        const response = await makeHttpRequest<changeTaskInput, { message: string }>
        (endPoint, 'POST', { task_id: taskId, project_id: projectId});

        showSuccess(response.message);
    } catch (error) {
        showErrorResponse(error);
    }
}