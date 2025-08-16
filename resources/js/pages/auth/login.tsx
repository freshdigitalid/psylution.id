import { Link, useForm } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';
import { FormEventHandler } from 'react';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from "@/components/ui/separator";
import AppLogoIcon from '@/components/app-logo-icon';
import axios from 'axios';

type LoginForm = {
    email: string;
    password: string;
    remember: boolean;
};

export default function Login() {

    const { data, setData, processing, errors } = useForm<Required<LoginForm>>({
        email: '',
        password: '',
        remember: false,
    });

    const submit: FormEventHandler = async (e) => {
        e.preventDefault();
        const response = await axios.post(route('login'), data);
        if (response.data.redirect) {
            window.location.href = response.data.redirect;
        }
    };

    return (
        <div className="h-screen flex items-center justify-center">
            <div className="w-full h-full grid lg:grid-cols-2">
                <div className="max-w-xs m-auto w-full flex flex-col items-center">
                    <Link href={route('home')} className="flex flex-col items-center gap-2 font-medium">
                        <div className="mb-1 flex h-9 w-9 items-center justify-center rounded-md">
                            <AppLogoIcon className="size-9 fill-current text-[var(--foreground)] dark:text-white" />
                        </div>
                        <span className="sr-only">Log in to Psylution</span>
                    </Link>
                    <p className="mt-4 text-xl font-bold tracking-tight">
                        Log in to Psylution
                    </p>
                    <Button asChild>
                        <a href={route('login.provider', 'google', { preserveState: true })} className="mt-8 w-full gap-3">
                            <GoogleLogo />
                            Continue with Google
                        </a>
                    </Button>
                    <div className="my-7 w-full flex items-center justify-center overflow-hidden">
                        <Separator />
                        <span className="text-sm px-2">OR</span>
                        <Separator />
                    </div>
                    <form
                        className="w-full space-y-4" onSubmit={submit}>

                        <div className="grid gap-2">
                            <Label htmlFor="email">Email address</Label>
                            <Input
                                className="w-full"
                                id="email"
                                type="email"
                                required
                                autoFocus
                                tabIndex={1}
                                autoComplete="email"
                                value={data.email}
                                onChange={(e) => setData('email', e.target.value)}
                                placeholder="email@example.com"
                            />
                            <InputError message={errors.email} />
                        </div>
                        <div className="grid gap-2">
                            <Label htmlFor="password">Password</Label>
                            <Input
                                id="password"
                                type="password"
                                required
                                tabIndex={2}
                                autoComplete="current-password"
                                value={data.password}
                                onChange={(e) => setData('password', e.target.value)}
                                placeholder="Password"
                            />
                            <InputError message={errors.password} />
                        </div>
                        <Button type="submit" className="mt-4 w-full" tabIndex={4} disabled={processing}>
                            {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                            Continue with Email
                        </Button>
                    </form>
                    <div className="mt-5 space-y-5">
                        <Link
                            href="#"
                            className="text-sm block underline text-muted-foreground text-center"
                        >
                            Forgot your password?
                        </Link>
                        <p className="text-sm text-center">
                            Don&apos;t have an account?
                            <Link href="#" className="ml-1 underline text-muted-foreground">
                                Create account
                            </Link>
                        </p>
                    </div>
                </div>
                <div className="bg-muted hidden lg:block" />
            </div>
        </div>
    );
};

const GoogleLogo = () => (
    <svg
        width="1.2em"
        height="1.2em"
        id="icon-google"
        viewBox="0 0 16 16"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        className="inline-block shrink-0 align-sub text-[inherit] size-lg"
    >
        <g clipPath="url(#clip0)">
            <path
                d="M15.6823 8.18368C15.6823 7.63986 15.6382 7.0931 15.5442 6.55811H7.99829V9.63876H12.3194C12.1401 10.6323 11.564 11.5113 10.7203 12.0698V14.0687H13.2983C14.8122 12.6753 15.6823 10.6176 15.6823 8.18368Z"
                fill="#4285F4"
            ></path>
            <path
                d="M7.99812 16C10.1558 16 11.9753 15.2915 13.3011 14.0687L10.7231 12.0698C10.0058 12.5578 9.07988 12.8341 8.00106 12.8341C5.91398 12.8341 4.14436 11.426 3.50942 9.53296H0.849121V11.5936C2.2072 14.295 4.97332 16 7.99812 16Z"
                fill="#34A853"
            ></path>
            <path
                d="M3.50665 9.53295C3.17154 8.53938 3.17154 7.4635 3.50665 6.46993V4.4093H0.849292C-0.285376 6.66982 -0.285376 9.33306 0.849292 11.5936L3.50665 9.53295Z"
                fill="#FBBC04"
            ></path>
            <path
                d="M7.99812 3.16589C9.13867 3.14825 10.241 3.57743 11.067 4.36523L13.3511 2.0812C11.9048 0.723121 9.98526 -0.0235266 7.99812 -1.02057e-05C4.97332 -1.02057e-05 2.2072 1.70493 0.849121 4.40932L3.50648 6.46995C4.13848 4.57394 5.91104 3.16589 7.99812 3.16589Z"
                fill="#EA4335"
            ></path>
        </g>
        <defs>
            <clipPath id="clip0">
                <rect width="15.6825" height="16" fill="white"></rect>
            </clipPath>
        </defs>
    </svg>
);