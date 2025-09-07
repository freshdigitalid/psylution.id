import { Head, Link, useForm } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';
import { FormEventHandler } from 'react';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/auth-layout';
import { format, startOfDay } from 'date-fns';
import { Calendar } from '@/components/ui/calendar';
import { DateInput } from '@/components/ui/date-input';

type RegisterForm = {
    first_name: string;
    last_name: string;
    dob: Date;
    email: string;
    password: string;
    password_confirmation: string;
    phone_number: string;
};

export default function Register() {
    const { data, setData, post, processing, errors, reset, transform } = useForm<Required<RegisterForm>>({
        first_name: '',
        last_name: '',
        dob: new Date(),
        email: '',
        password: '',
        password_confirmation: '',
        phone_number: '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        
        transform((data) => ({
            ...data,
            phone_number: '+62' + data.phone_number.replace(/^0+/, ''),
        }));
        
        post(route('register'), {
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };

    return (
        <AuthLayout title="Create an account" description="Enter your details below to create your account">
            <Head title="Register" />
            <form className="flex flex-col gap-6" onSubmit={submit}>
                <div className="grid gap-6">
                    <div className="grid grid-cols-2 gap-2">
                        <div>
                            <Label htmlFor="first_name">First Name</Label>
                            <Input
                                id="first_name"
                                type="text"
                                required
                                autoFocus
                                tabIndex={1}
                                autoComplete="first_name"
                                value={data.first_name}
                                onChange={(e) => setData('first_name', e.target.value)}
                                disabled={processing}
                                placeholder="First name"
                                error={errors.first_name}
                            />
                        </div>
                        <div>
                            <Label htmlFor="last_name">Last Name</Label>
                            <Input
                                id="last_name"
                                type="text"
                                required
                                autoFocus
                                tabIndex={1}
                                autoComplete="last_name"
                                value={data.last_name}
                                onChange={(e) => setData('last_name', e.target.value)}
                                disabled={processing}
                                placeholder="Last name"
                                error={errors.last_name}
                            />
                        </div>
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="email">Email address</Label>
                        <Input
                            id="email"
                            type="email"
                            required
                            tabIndex={2}
                            autoComplete="email"
                            value={data.email}
                            onChange={(e) => setData('email', e.target.value)}
                            disabled={processing}
                            placeholder="email@example.com"
                            error={errors.email}
                        />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="dob">Birthday</Label>
                        <DateInput
                            onChange={(e) => {
                                setData("dob", startOfDay(e!))
                            }}
                            value={data.dob}
                            error={errors.dob}
                        />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="phone">Phone Number</Label>
                        <div className='relative'>
                            <Input
                                id="phone"
                                className='peer ps-12'
                                type="tel"
                                inputMode="numeric"
                                pattern="[0-9]*"
                                value={data.phone_number}
                                onChange={(e) => setData('phone_number', e.target.value)}
                                disabled={processing}
                                error={errors.phone_number} />
                            <span className='pointer-events-none absolute inset-y-0 start-0 flex items-center justify-center ps-3 text-sm peer-disabled:opacity-50'>
                                +62
                            </span>
                        </div>
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="password">Password</Label>
                        <Input
                            id="password"
                            type="password"
                            required
                            tabIndex={3}
                            autoComplete="new-password"
                            value={data.password}
                            onChange={(e) => setData('password', e.target.value)}
                            disabled={processing}
                            placeholder="Password"
                            error={errors.password}
                        />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="password_confirmation">Confirm password</Label>
                        <Input
                            id="password_confirmation"
                            type="password"
                            required
                            tabIndex={4}
                            autoComplete="new-password"
                            value={data.password_confirmation}
                            onChange={(e) => setData('password_confirmation', e.target.value)}
                            disabled={processing}
                            placeholder="Confirm password"
                            error={errors.password_confirmation}
                        />
                    </div>

                    <Button type="submit" className="mt-2 w-full" tabIndex={5} disabled={processing}>
                        {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                        Create account
                    </Button>
                </div>

                <div className="text-center text-sm text-muted-foreground">
                    Already have an account?{' '}
                    <Button variant={'link'} asChild tabIndex={6} className='px-0'>
                        <Link href={route('login')}>
                            Log in
                        </Link>
                    </Button>
                </div>
            </form>
        </AuthLayout>
    );
}
