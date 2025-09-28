import Footer from '@/components/footer';
import Navbar from '@/components/navbar/navbar';
import { Toaster } from '@/components/ui/sonner';
import { type ReactNode } from 'react';

interface AppLayoutProps {
    children: ReactNode;
}

export default ({ children }: AppLayoutProps) => (
    <>
        <Navbar />
        <main className="py-20 pt-16 xs:pt-20 sm:pt-24">{children}</main>
        <Footer />
        <Toaster />
    </>
);
