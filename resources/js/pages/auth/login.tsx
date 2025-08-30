import { Link, useForm } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';
import { FormEventHandler } from 'react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from "@/components/ui/separator";
import AppLogoIcon from '@/components/app-logo-icon';

type LoginForm = {
    email: string;
    password: string;
};

export default function Login() {
    const { data, setData, processing, errors, post } = useForm<Required<LoginForm>>({
        email: '',
        password: '',
    });

    const submit: FormEventHandler = async (e) => {
        e.preventDefault();
        post('login');
    };

    return (
        <div className="min-h-screen w-full grid lg:grid-cols-2">
            {/* Left info panel */}
            <div className="hidden lg:flex flex-col justify-between p-8 bg-[#CADFFE]">
                <div className="flex items-center gap-3">
                    <AppLogoIcon className="h-50 w-50" />
                </div>
                <div className="px-8">
                    <h2 className="text-4xl font-extrabold tracking-tight text-[#1E2547]">Lorem Ipsum</h2>
                    <p className="mt-4 text-sm leading-6 text-[#1E2547]/80">
                        Lorem ipsum dolor sit amet consectetur. Aliquet bibendum fringilla cras nisl commodo sit facilisi massa euismod.
                    </p>
                </div>
                <div className="px-8 pb-4">
                    <p className="text-sm text-[#1E2547]/80">Don&apos;t have an account?</p>
                    <Link href="/register">
                        <Button variant="outline" className="mt-3 rounded-full border-[#5274FF] text-[#5274FF] hover:bg-[#5274FF]/10">
                            Sign Up
                        </Button>
                    </Link>
                </div>
            </div>

            {/* Right form panel */}
            <div className="flex items-center justify-center py-10">
                <div className="w-full max-w-md px-8">
                    <p className="text-2xl font-extrabold text-[#1E2547]">Log In</p>

                    <Button asChild className="mt-8 w-full gap-3">
                        <a href="/auth/google">
                            <GoogleLogo />
                            Continue with Google
                        </a>
                    </Button>

                    <div className="my-7 w-full flex items-center justify-center overflow-hidden">
                        <Separator />
                        <span className="text-sm px-2">OR</span>
                        <Separator />
                    </div>

                    <form className="w-full space-y-4" onSubmit={submit}>
                        <div className="grid gap-2">
                            <Label htmlFor="email">Email</Label>
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
                                error={errors.email}
                            />
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
                                error={errors.password}
                            />
                        </div>

                        <div className="mt-2 flex items-center justify-between">
                            <Link href="/forgot-password" className="text-sm text-[#5274FF] hover:underline">
                                Forgot password?
                            </Link>
                        </div>

                        <Button type="submit" className="mt-6 w-full bg-[#5274FF] hover:bg-[#4666f0]" tabIndex={4} disabled={processing}>
                            {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                            Log In
                        </Button>
                    </form>
                </div>
            </div>
        </div>
    );
}

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
            />
            <path
                d="M7.99812 16C10.1558 16 11.9753 15.2915 13.3011 14.0687L10.7231 12.0698C10.0058 12.5578 9.07988 12.8341 8.00106 12.8341C5.91398 12.8341 4.14436 11.426 3.50942 9.53296H0.849121V11.5936C2.2072 14.295 4.97332 16 7.99812 16Z"
                fill="#34A853"
            />
            <path
                d="M3.50665 9.53295C3.17154 8.53938 3.17154 7.4635 3.50665 6.46993V4.4093H0.849292C-0.285376 6.66982 -0.285376 9.33306 0.849292 11.5936L3.50665 9.53295Z"
                fill="#FBBC04"
            />
            <path
                d="M7.99812 3.16589C9.13867 3.14825 10.241 3.57743 11.067 4.36523L13.3511 2.0812C11.9048 0.723121 9.98526 -0.0235266 7.99812 -1.02057e-05C4.97332 -1.02057e-05 2.2072 1.70493 0.849121 4.40932L3.50648 6.46995C4.13848 4.57394 5.91104 3.16589 7.99812 3.16589Z"
                fill="#EA4335"
            />
        </g>
        <defs>
            <clipPath id="clip0">
                <rect width="15.6825" height="16" fill="white" />
            </clipPath>
        </defs>
    </svg>
);