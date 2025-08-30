import { Head, useForm } from '@inertiajs/react';
import { LoaderCircle, MessageCircle } from 'lucide-react';
import { FormEventHandler, useEffect, useRef, useState } from 'react';

import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/auth-layout';

interface OtpVerifyProps {
    phone: string;
    email: string;
}

export default function OtpVerify({ phone, email }: OtpVerifyProps) {
    const [otp, setOtp] = useState(['', '', '', '', '', '']);
    const inputRefs = useRef<(HTMLInputElement | null)[]>([]);

    const { post, processing, errors, reset } = useForm({
        otp: '',
    });

    const handleOtpChange = (index: number, value: string) => {
        if (value.length > 1) return; // Prevent multiple characters

        const newOtp = [...otp];
        newOtp[index] = value;
        setOtp(newOtp);

        // Move to next input if value is entered
        if (value && index < 5) {
            inputRefs.current[index + 1]?.focus();
        }

        // Move to previous input if value is deleted
        if (!value && index > 0) {
            inputRefs.current[index - 1]?.focus();
        }
    };

    const handleKeyDown = (index: number, e: React.KeyboardEvent) => {
        if (e.key === 'Backspace' && !otp[index] && index > 0) {
            inputRefs.current[index - 1]?.focus();
        }
    };

    const handlePaste = (e: React.ClipboardEvent) => {
        e.preventDefault();
        const pastedData = e.clipboardData.getData('text/plain').slice(0, 6);
        if (/^\d{6}$/.test(pastedData)) {
            const newOtp = pastedData.split('');
            setOtp([...newOtp, ...Array(6 - newOtp.length).fill('')]);
        }
    };

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        const otpString = otp.join('');
        if (otpString.length === 6) {
            post(route('otp.verify'), {
                data: { otp: otpString },
                onFinish: () => reset(),
            });
        }
    };

    const resendOtp = () => {
        post(route('otp.resend'));
    };

    // Auto-submit when all 6 digits are entered
    useEffect(() => {
        const otpString = otp.join('');
        if (otpString.length === 6) {
            post(route('otp.verify'), {
                data: { otp: otpString },
                onFinish: () => reset(),
            });
        }
    }, [otp]);

    return (
        <AuthLayout title="Verify Your Account" description="Enter the 6-digit code sent to your WhatsApp">
            <Head title="OTP Verification" />

            <div className="flex flex-col gap-6">
                {/* Phone Number Display */}
                <div className="text-center">
                    <div className="mb-2 flex items-center justify-center gap-2">
                        <MessageCircle className="h-5 w-5 text-blue-600" />
                        <span className="text-sm text-gray-600">WhatsApp</span>
                    </div>
                    <p className="text-sm text-gray-600">
                        Code sent to <span className="font-medium">{phone}</span>
                    </p>
                </div>

                {/* OTP Input */}
                <form onSubmit={submit} className="space-y-6">
                    <div className="space-y-4">
                        <Label htmlFor="otp" className="block text-center">
                            Enter 6-digit code
                        </Label>

                        <div className="flex justify-center gap-2">
                            {otp.map((digit, index) => (
                                <Input
                                    key={index}
                                    ref={(el) => (inputRefs.current[index] = el)}
                                    type="text"
                                    inputMode="numeric"
                                    pattern="[0-9]*"
                                    maxLength={1}
                                    value={digit}
                                    onChange={(e) => handleOtpChange(index, e.target.value)}
                                    onKeyDown={(e) => handleKeyDown(index, e)}
                                    onPaste={handlePaste}
                                    className="h-12 w-12 text-center text-lg font-semibold"
                                    disabled={processing}
                                />
                            ))}
                        </div>

                        <InputError message={errors.otp} className="text-center" />
                    </div>

                    <Button type="submit" className="w-full" disabled={processing || otp.join('').length !== 6}>
                        {processing && <LoaderCircle className="mr-2 h-4 w-4 animate-spin" />}
                        Verify Account
                    </Button>
                </form>

                {/* Resend OTP */}
                <div className="text-center">
                    <p className="mb-2 text-sm text-gray-600">Didn't receive the code?</p>
                    <Button variant="link" onClick={resendOtp} disabled={processing} className="text-blue-600 hover:text-blue-700">
                        Resend Code
                    </Button>
                </div>

                {/* Back to Register */}
                <div className="text-center">
                    <Button variant="ghost" onClick={() => window.history.back()} className="text-gray-600 hover:text-gray-700">
                        ← Back to Register
                    </Button>
                </div>
            </div>
        </AuthLayout>
    );
}
