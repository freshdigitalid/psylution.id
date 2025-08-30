import PaymentSuccessAlert from '@/components/ui/payment-success-alert';
import StatusAlert from '@/components/ui/status-alert';
import { Head } from '@inertiajs/react';

const AlertsExamplePage = () => {
    return (
        <>
            <Head title="Alert Examples" />

            {/* Payment Success Alert (Original Design) */}
            <div className="mb-8">
                <h2 className="mb-4 text-2xl font-bold">Payment Success Alert (Original Design)</h2>
                <PaymentSuccessAlert
                    title="Payment Success"
                    message="Pembayaran Anda telah berhasil diproses. Terima kasih telah menggunakan layanan kami."
                    buttonText="Kembali ke Beranda"
                    buttonHref="/"
                />
            </div>

            {/* Status Alerts Examples */}
            <div className="space-y-8">
                <div>
                    <h2 className="mb-4 text-2xl font-bold">Success Alert</h2>
                    <StatusAlert
                        type="success"
                        title="Pembayaran Berhasil"
                        message="Pembayaran Anda telah berhasil diproses. Terima kasih telah menggunakan layanan kami."
                        buttonText="Kembali ke Beranda"
                        buttonHref="/"
                    />
                </div>

                <div>
                    <h2 className="mb-4 text-2xl font-bold">Error Alert</h2>
                    <StatusAlert
                        type="error"
                        title="Pembayaran Gagal"
                        message="Maaf, pembayaran Anda gagal diproses. Silakan coba lagi atau hubungi customer service."
                        buttonText="Coba Lagi"
                        onButtonClick={() => console.log('Retry payment')}
                    />
                </div>

                <div>
                    <h2 className="mb-4 text-2xl font-bold">Warning Alert</h2>
                    <StatusAlert
                        type="warning"
                        title="Peringatan"
                        message="Sesi Anda akan berakhir dalam 5 menit. Silakan simpan pekerjaan Anda."
                        buttonText="Lanjutkan"
                        onButtonClick={() => console.log('Continue session')}
                    />
                </div>

                <div>
                    <h2 className="mb-4 text-2xl font-bold">Info Alert</h2>
                    <StatusAlert
                        type="info"
                        title="Informasi"
                        message="Fitur baru telah tersedia. Silakan cek halaman beranda untuk informasi lebih lanjut."
                        buttonText="Lihat Fitur Baru"
                        buttonHref="/"
                        showBackIcon={true}
                    />
                </div>
            </div>
        </>
    );
};

export default AlertsExamplePage;
