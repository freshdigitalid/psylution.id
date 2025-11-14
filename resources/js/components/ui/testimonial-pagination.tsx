import React from 'react';
import {
  Pagination,
  PaginationContent,
  PaginationItem,
  PaginationLink,
  PaginationEllipsis,
} from '@/components/ui/pagination';

interface TestimonialPaginationProps {
  currentPage: number;
  totalPages: number;
  onPageChange: (page: number) => void;
}

export const TestimonialPagination: React.FC<TestimonialPaginationProps> = ({
  currentPage,
  totalPages,
  onPageChange,
}) => {
  const getVisiblePages = () => {
    const delta = 2;
    const pages: (number | string)[] = [];

    // Always show first page
    pages.push(1);

    // Calculate start and end of middle range
    let start = Math.max(2, currentPage - delta);
    let end = Math.min(totalPages - 1, currentPage + delta);

    // Add ellipsis before if needed
    if (start > 2) {
      pages.push('...');
    }

    // Add middle range pages (exclude first and last if they're already added)
    for (let i = start; i <= end; i++) {
      if (i !== 1 && i !== totalPages) {
        pages.push(i);
      }
    }

    // Add ellipsis after if needed
    if (end < totalPages - 1) {
      pages.push('...');
    }

    // Always show last page (if more than 1 page total)
    if (totalPages > 1) {
      pages.push(totalPages);
    }

    // Remove duplicates while preserving order
    const uniquePages: (number | string)[] = [];
    const seen = new Set<string | number>();
    
    pages.forEach(page => {
      const key = typeof page === 'string' ? `ellipsis_${uniquePages.filter(p => p === '...').length}` : page;
      if (!seen.has(key)) {
        seen.add(key);
        uniquePages.push(page);
      }
    });

    return uniquePages;
  };

  if (totalPages <= 1) return null;

  return (
    <Pagination className="mt-8">
      <PaginationContent>
        {getVisiblePages().map((page, index) => (
          <PaginationItem key={`page-${typeof page === 'string' ? `ellipsis-${index}` : page}`}>
            {page === '...' ? (
              <PaginationEllipsis />
            ) : (
              <PaginationLink
                href="#"
                onClick={(e) => {
                  e.preventDefault();
                  onPageChange(page as number);
                }}
                isActive={currentPage === page}
              >
                {page}
              </PaginationLink>
            )}
          </PaginationItem>
        ))}
      </PaginationContent>
    </Pagination>
  );
};
