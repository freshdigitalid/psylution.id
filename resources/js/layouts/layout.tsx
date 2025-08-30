import Navbar from '@/components/navbar/navbar';
import Footer from '@/components/footer';
import { type ReactNode } from 'react';

interface AppLayoutProps {
    children: ReactNode;
}

export default ({ children, ...props }: AppLayoutProps) => (
    <>
        <Navbar />
        <main className="pt-16 xs:pt-20 sm:pt-24 py-20">
            {children}
        </main>
        <Footer />
    </>
);
