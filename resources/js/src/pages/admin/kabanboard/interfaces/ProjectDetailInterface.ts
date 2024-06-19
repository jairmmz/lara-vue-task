import { ITask, ITaskProgress } from "./TaskInterface";

interface IProject {
    id: string;
    name: string;
    status: number;
    start_date: string;
    end_date: string;
    slug: string;
}

export enum TaskStatus {
    NOT_STARTED = 0 as number,
    PENDING = 1 as number,
    COMPLETED = 2 as number
}

export interface ISingleProjectResponse {
    message: string;
    data: {
        project: IProject;
        tasks: ITask[];
        task_progress: ITaskProgress;
    };
    code: number;
};
