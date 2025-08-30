# Alert Components

Komponen alert yang dibuat menggunakan shadcn/ui untuk menampilkan berbagai jenis notifikasi.

## PaymentSuccessAlert

Komponen khusus untuk menampilkan konfirmasi pembayaran berhasil dengan desain yang sesuai dengan mockup.

### Props

- `title?: string` - Judul alert (default: "Payment Success")
- `message?: string` - Pesan tambahan
- `buttonText?: string` - Teks tombol (default: "Go Back")
- `buttonHref?: string` - URL untuk navigasi tombol
- `onButtonClick?: () => void` - Function yang dipanggil saat tombol diklik

### Contoh Penggunaan

```tsx
import PaymentSuccessAlert from '@/components/ui/payment-success-alert';

// Basic usage
<PaymentSuccessAlert />

// With custom content
<PaymentSuccessAlert 
    title="Pembayaran Berhasil"
    message="Terima kasih telah menggunakan layanan kami."
    buttonText="Kembali ke Beranda"
    buttonHref="/"
/>
```

## StatusAlert

Komponen alert yang lebih fleksibel untuk berbagai jenis status (success, error, warning, info).

### Props

- `type?: 'success' | 'error' | 'warning' | 'info'` - Jenis alert (default: "success")
- `title?: string` - Judul alert
- `message?: string` - Pesan tambahan
- `buttonText?: string` - Teks tombol (default: "Go Back")
- `buttonHref?: string` - URL untuk navigasi tombol
- `onButtonClick?: () => void` - Function yang dipanggil saat tombol diklik
- `showBackIcon?: boolean` - Menampilkan ikon back pada tombol (default: false)
- `className?: string` - Class tambahan untuk styling

### Contoh Penggunaan

```tsx
import StatusAlert from '@/components/ui/status-alert';

// Success alert
<StatusAlert 
    type="success"
    title="Pembayaran Berhasil"
    message="Pembayaran Anda telah berhasil diproses."
    buttonText="Kembali ke Beranda"
    buttonHref="/"
/>

// Error alert
<StatusAlert 
    type="error"
    title="Pembayaran Gagal"
    message="Maaf, pembayaran Anda gagal diproses."
    buttonText="Coba Lagi"
    onButtonClick={() => console.log('Retry')}
/>

// Warning alert
<StatusAlert 
    type="warning"
    title="Peringatan"
    message="Sesi Anda akan berakhir dalam 5 menit."
    buttonText="Lanjutkan"
    onButtonClick={() => console.log('Continue')}
/>

// Info alert with back icon
<StatusAlert 
    type="info"
    title="Informasi"
    message="Fitur baru telah tersedia."
    buttonText="Lihat Fitur Baru"
    buttonHref="/features"
    showBackIcon={true}
/>
```

## Warna dan Styling

### PaymentSuccessAlert
- Background: `#E0EFFF` (biru muda)
- Border: `#3366FF` (biru tua)
- Icon background: `#5C7CFF` (biru cerah)
- Icon: `CheckCircle` dari Lucide React

### StatusAlert
Setiap jenis alert memiliki warna yang berbeda:

- **Success**: Biru (sesuai desain asli)
- **Error**: Merah
- **Warning**: Kuning
- **Info**: Biru

## Halaman Contoh

Untuk melihat semua contoh alert, kunjungi: `/examples/alerts`

## Route yang Tersedia

- `/payment/success` - Halaman payment success
- `/examples/alerts` - Halaman contoh semua jenis alert 