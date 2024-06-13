export interface IMember {
    id: string;
    name: string;
    email: string;
}

export interface IGetMembers {
    message: string;
    data: {
        data: IMember[];
    };
    code: number;
}

export interface IMemberCreate {
    name: string;
    email: string;
}

export interface IMemberResponse {
    message: string;
    data: IMember;
}

export interface IMemberUpdate {
    id: string;
    name: string;
    email: string;
}