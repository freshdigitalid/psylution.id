
interface LinkPaginationDto {
    url: string | null;
    label: string;
    page: number | null;
    active: boolean;
}

interface PaginationDto {
    current_page: number;
    data: any;
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    links: LinkPaginationDto[];
    next_page_url: string;
    path: string;
    per_page: number;
    prev_page_url: string;
    to: number;
    total: number;
}