export interface Role {
    id: number;
    name: string;
    display_name: string;
    description?: string;
    created_at: string;
    updated_at: string;
}

export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
    avatar?: string;
    role_id: number;
    role?: Role;
    created_at: string;
    updated_at: string;
    deleted_at?: string;
}

export interface SharedData {
    props: {
        auth: {
            user: User | null;
        };
        [key: string]: any;
    };
} 