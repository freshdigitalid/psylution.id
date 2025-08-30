import PaymentSuccessAlert from '@/components/ui/payment-success-alert';
import { Head } from '@inertiajs/react';

const PaymentSuccessPage = () => {
    return (
        <>
            <Head title="Payment Success" />
            <PaymentSuccessAlert
                title="Payment Success"
                message="Pembayaran Anda telah berhasil diproses. Terima kasih telah menggunakan layanan kami."
                buttonText="Kembali ke Beranda"
                buttonHref="/"
            />
        </>
    );
};

export default PaymentSuccessPage;
