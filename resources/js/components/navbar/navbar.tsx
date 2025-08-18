import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { SharedData, User } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { Logo } from './logo';
import { NavMenu } from './nav-menu';
import { NavigationSheet } from './navigation-sheet';
import ThemeToggle from './theme-toggle';

const Navbar = () => {
    const { auth } = usePage<SharedData>().props;
    const user = auth.user as User | null;

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

    const getInitials = (name: string) => {
        return name
            .split(' ')
            .map((word) => word.charAt(0))
            .join('')
            .toUpperCase()
            .slice(0, 2);
    };

    return (
        <nav className="fixed inset-x-4 top-6 z-10 mx-auto h-14 max-w-screen-xl rounded-full border bg-background/50 backdrop-blur-sm xs:h-16 dark:border-slate-700/70">
            <div className="mx-auto flex h-full items-center justify-between px-4">
                <Logo />

                {/* Desktop Menu */}
                <NavMenu className="hidden md:block" />

                <div className="flex items-center gap-3">
                    {user ? (
                        <div className="flex items-center gap-3">
                            {/* Show Dashboard button only for admin and psychologist */}
                            {(user.role?.name === 'admin' || user.role?.name === 'psychologist') && (
                                <Button
                                    onClick={() => openDashboard(user.role?.name as string)}
                                    variant={'outline'}
                                    className="hidden sm:inline-flex"
                                >
                                    Dashboard
                                </Button>
                            )}

                            <DropdownMenu>
                                <DropdownMenuTrigger asChild>
                                    <Button variant="ghost" className="relative h-8 w-8 rounded-full">
                                        <Avatar className="h-8 w-8">
                                            <AvatarImage src={user.avatar} alt={user.name} />
                                            <AvatarFallback>{getInitials(user.name)}</AvatarFallback>
                                        </Avatar>
                                    </Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent className="w-56" align="end" forceMount>
                                    <DropdownMenuLabel className="font-normal">
                                        <div className="flex flex-col space-y-1">
                                            <p className="text-sm leading-none font-medium">{user.name}</p>
                                            <p className="text-xs leading-none text-muted-foreground">{user.email}</p>
                                            <Badge variant="secondary" className="w-fit capitalize">
                                                {user.role?.name || 'Patient'}
                                            </Badge>
                                        </div>
                                    </DropdownMenuLabel>
                                    <DropdownMenuSeparator />

                                    {/* Show Dashboard link only for admin and psychologist */}
                                    {(user.role?.name === 'admin' || user.role?.name === 'psychologist') && (
                                        <DropdownMenuItem asChild>
                                            <Link href={route('filament.patient.pages.dashboard')}>Dashboard</Link>
                                        </DropdownMenuItem>
                                    )}

                                    <DropdownMenuSeparator />
                                    <DropdownMenuItem asChild>
                                        <Link href={route('logout')} method="post" as="button">
                                            Log out
                                        </Link>
                                    </DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </div>
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
