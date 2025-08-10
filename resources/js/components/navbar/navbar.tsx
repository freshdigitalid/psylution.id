import { Button } from "@/components/ui/button";
import { Logo } from "./logo";
import { NavMenu } from "./nav-menu";
import { NavigationSheet } from "./navigation-sheet";
import ThemeToggle from "./theme-toggle";
import { SharedData } from "@/types";
import { Link, usePage } from "@inertiajs/react";

const Navbar = () => {
    const { auth } = usePage<SharedData>().props;

    function openDashboard(role: string) {
        // Redirect to the appropriate dashboard based on user role
        switch (role) {
            case 'admin':
                window.location.href = route('filament.admin.pages.dashboard');
                break;
            case 'psychologist':
                window.location.href = route('filament.psychologist.pages.dashboard');
                break;
            default:
                window.location.href = route('filament.patient.pages.dashboard');
                break;
        }
    }

    return (
        <nav className="fixed z-10 top-6 inset-x-4 h-14 xs:h-16 bg-background/50 backdrop-blur-sm border dark:border-slate-700/70 max-w-screen-xl mx-auto rounded-full">
            <div className="h-full flex items-center justify-between mx-auto px-4">
                <Logo />

                {/* Desktop Menu */}
                <NavMenu className="hidden md:block" />

                <div className="flex items-center gap-3">
                    {auth.user ? (
                        <Button
                            onClick={() => openDashboard(auth.user.role as string)}
                            variant={'outline'}
                            className="hidden sm:inline-flex"
                        >
                            Dashboard
                        </Button>
                    ) : (
                        <>
                            <Button asChild variant="outline" className="hidden sm:inline-flex">
                                <Link href={route('login')}>Log in</Link>
                            </Button>
                            <Button asChild className="hidden xs:inline-flex">
                                <Link href={route('register')}>Register</Link>
                            </Button>
                        </>
                    )}
                    <ThemeToggle />
                    {/* Mobile Menu */}
                    <div className="md:hidden">
                        <NavigationSheet />
                    </div>
                </div>
            </div>
        </nav>
    );
};

export default Navbar;