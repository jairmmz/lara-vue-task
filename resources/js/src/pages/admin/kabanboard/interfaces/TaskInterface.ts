export interface ITaskCreate {
    name: string;
    member_id: string[];
    project_id: string | undefined;
}

export interface ITask {
    id: string;
    project_id: string;
    name: string;
    status: number;
    task_members: ITaskMember[];
}

export interface ITaskMember {
    id: string;
    project_id: string;
    task_id: string;
    member_id: string;
    member: IMember;
}

export interface ITaskProgress {
    project_id: string;
    pinned_on_dashboard: number;
    progress: string;
}

interface IMember {
    name: string;
    email: string;
}