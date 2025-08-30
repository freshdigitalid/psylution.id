# Sistem OTP WhatsApp - Psylution

## Overview

Sistem OTP WhatsApp telah diintegrasikan ke dalam proses registrasi user untuk memverifikasi nomor telepon melalui WhatsApp.

## Fitur Utama

### ✅ **Registrasi dengan OTP**

- User mendaftar dengan nama, email, dan nomor telepon
- Sistem generate OTP 6 digit
- OTP dikirim via WhatsApp menggunakan StarSender API
- User harus verifikasi OTP sebelum akun aktif

### ✅ **Verifikasi OTP**

- Halaman verifikasi OTP yang user-friendly
- Input OTP 6 digit dengan auto-focus
- Auto-submit ketika semua digit terisi
- Support paste OTP dari clipboard

### ✅ **Resend OTP**

- User bisa request OTP baru
- OTP lama otomatis invalid
- Rate limiting untuk mencegah spam

## Database Structure

### Tabel `users`

```sql
ALTER TABLE users ADD COLUMN phone_number VARCHAR(255) NULL;
ALTER TABLE users ADD COLUMN is_verified BOOLEAN DEFAULT FALSE;
```

### Tabel `user_otps`

```sql
CREATE TABLE user_otps (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    otp_code VARCHAR(6) NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    is_used BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## API Integration

### StarSender WhatsApp API

```php
// Konfigurasi di config/services.php
'starsender' => [
    'api_key' => env('STARSENDER_API_KEY'),
    'api_url' => env('STARSENDER_API_URL', 'https://api.starsender.online/api'),
],

// Environment variables
STARSENDER_API_KEY=your_api_key_here
STARSENDER_API_URL=https://api.starsender.online/api
```

### Format Pesan OTP

```
Kode OTP Psylution Anda adalah: {OTP_CODE}.
Berlaku selama 5 menit.
Jangan bagikan kode ini kepada siapapun.
```

## Flow Registrasi

```
1. User mengisi form registrasi
   ├── Nama
   ├── Email
   ├── Nomor Telepon (format: 08123456789)
   └── Password

2. Sistem validasi data
   ├── Email unik
   ├── Nomor telepon valid (regex: /^(\+62|62|0)8[1-9][0-9]{6,9}$/)
   └── Password sesuai rules

3. Create user account
   ├── Hash password
   ├── Set role_id = 2 (patient)
   └── Set is_verified = false

4. Generate & kirim OTP
   ├── Generate OTP 6 digit
   ├── Set expires_at = now + 5 minutes
   ├── Kirim via WhatsApp
   └── Login user

5. Redirect ke halaman verifikasi OTP
   ├── Tampilkan nomor telepon
   └── Input OTP 6 digit

6. Verifikasi OTP
   ├── Validasi OTP
   ├── Check expires_at
   ├── Mark OTP as used
   ├── Set user.is_verified = true
   └── Redirect ke dashboard
```

## Routes

### Web Routes

```php
// OTP Routes (requires auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/otp/verify', [OtpController::class, 'showVerificationForm'])->name('otp.verify.form');
    Route::post('/otp/verify', [OtpController::class, 'verify'])->name('otp.verify');
    Route::post('/otp/resend', [OtpController::class, 'resend'])->name('otp.resend');
});
```

## Components

### Frontend Components

- `resources/js/pages/auth/register.tsx` - Form registrasi dengan phone number
- `resources/js/pages/auth/otp-verify.tsx` - Halaman verifikasi OTP

### Backend Controllers

- `app/Http/Controllers/Auth/RegisteredUserController.php` - Handle registrasi
- `app/Http/Controllers/OtpController.php` - Handle OTP verification

### Models

- `app/Models/User.php` - User model dengan field phone_number & is_verified
- `app/Models/UserOtp.php` - OTP model dengan scopes

### Requests

- `app/Http/Requests/StoreUserRequest.php` - Validasi registrasi

## Security Features

### ✅ **OTP Security**

- OTP expires dalam 5 menit
- OTP hanya bisa digunakan sekali
- Rate limiting untuk resend OTP
- Validasi format nomor telepon

### ✅ **Data Protection**

- Password di-hash menggunakan bcrypt
- Nomor telepon divalidasi format Indonesia
- Session management untuk OTP flow
- Error handling yang aman

## Error Handling

### Common Errors

```php
// OTP expired
'otp' => 'Kode OTP tidak valid atau sudah kadaluarsa.'

// Invalid phone number
'phone_number.regex' => 'Nomor telepon harus valid dan dimulai dengan 08 atau +62.'

// WhatsApp API failed
Log::warning('Failed to send WhatsApp OTP: ' . $e->getMessage());
```

## Testing

### Manual Testing

1. Register dengan nomor telepon valid
2. Check WhatsApp untuk OTP
3. Input OTP di halaman verifikasi
4. Verify akun berhasil

### API Testing

```bash
# Test StarSender API
curl -X POST https://api.starsender.online/api/send \
  -H "Authorization: YOUR_API_KEY" \
  -H "Content-Type: application/json" \
  -d '{
    "messageType": "text",
    "to": "628123456789",
    "body": "Test OTP: 123456"
  }'
```

## Configuration

### Environment Variables

```env
# StarSender WhatsApp API
STARSENDER_API_KEY=your_api_key_here
STARSENDER_API_URL=https://api.starsender.online/api

# Optional: Disable WhatsApp for development
DISABLE_WHATSAPP_OTP=false
```

## Troubleshooting

### OTP tidak terkirim

1. Check StarSender API key
2. Verify nomor telepon format
3. Check API response logs
4. Fallback: OTP tetap disimpan di database

### User tidak bisa verifikasi

1. Check OTP expires_at
2. Verify OTP belum digunakan
3. Check user authentication
4. Clear session jika perlu

## Future Enhancements

### 🔮 **Planned Features**

- SMS fallback jika WhatsApp gagal
- Email OTP sebagai backup
- OTP rate limiting per IP
- Admin panel untuk manage OTP
- Analytics untuk OTP delivery rate
