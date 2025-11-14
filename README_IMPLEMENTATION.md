# Implementation Guide

## Overview

Implementasi ini menambahkan fitur-fitur berikut ke sistem appointment:

1. **Zoom API Integration** - Auto-generate Zoom meeting link ketika appointment online di-approve
2. **Google Meet API Support** - Struktur siap untuk integrasi Google Meet (optional)
3. **Flexible Payment Gateway** - Interface untuk memudahkan switching dari Xendit ke provider lain
4. **Auto Meeting Link Generation** - Link meeting otomatis dibuat di Filament dashboard

---

## 1. Video Conferencing Integration

### Zoom API Setup

1. **Dapatkan Zoom API Credentials:**
   - Login ke [Zoom Marketplace](https://marketplace.zoom.us/)
   - Buat Server-to-Server OAuth App atau JWT App
   - Copy API Key, API Secret, Account ID, dan Client Secret

2. **Tambahkan ke `.env`:**
```env
ZOOM_API_KEY=your_zoom_api_key
ZOOM_API_SECRET=your_zoom_api_secret
ZOOM_ACCOUNT_ID=your_zoom_account_id
ZOOM_CLIENT_SECRET=your_zoom_client_secret
ZOOM_USER_ID=me  # Optional, default: 'me'

# Provider selection
VIDEO_CONFERENCE_PROVIDER=zoom  # 'zoom' or 'google_meet'
```

3. **Cara Kerja:**
   - Ketika psychologist approve appointment dengan `is_online = true`
   - Sistem otomatis memanggil Zoom API untuk membuat meeting
   - Meeting URL otomatis tersimpan di field `meet_url`
   - Link muncul di dashboard patient dan psychologist

### Google Meet API Setup (Optional)

1. **Setup Google Cloud Project:**
   - Buat project di [Google Cloud Console](https://console.cloud.google.com/)
   - Enable Google Meet API
   - Buat OAuth 2.0 credentials
   - Dapatkan access token

2. **Tambahkan ke `.env`:**
```env
GOOGLE_MEET_ACCESS_TOKEN=your_access_token
GOOGLE_MEET_CLIENT_ID=your_client_id
GOOGLE_MEET_CLIENT_SECRET=your_client_secret

# Untuk switch ke Google Meet
VIDEO_CONFERENCE_PROVIDER=google_meet
```

**Note:** Google Meet API memerlukan setup OAuth yang lebih kompleks. Lihat [Google Meet API Documentation](https://developers.google.com/meet/api/guides/overview) untuk detail.

---

## 2. Payment Gateway Integration

### Current Implementation: Xendit

Xendit sudah diimplementasikan dan berfungsi dengan baik. Untuk menggunakan Xendit:

1. **Setup Xendit:**
   - Daftar di [Xendit](https://www.xendit.co/)
   - Dapatkan Secret Key dan Webhook Secret
   - Tambahkan ke `.env`:
```env
XENDIT_SECRET_KEY=your_xendit_secret_key
XENDIT_WEBHOOK_SECRET=your_xendit_webhook_secret

# Default payment gateway
PAYMENT_GATEWAY_PROVIDER=xendit
```

### Switching ke Payment Gateway Lain

Struktur sudah disiapkan untuk switching ke provider lain. Untuk menambahkan provider baru:

1. **Buat Service Class baru** yang implement `PaymentGatewayInterface`:
```php
// app/Services/PaymentGateway/MidtransPaymentGateway.php
class MidtransPaymentGateway implements PaymentGatewayInterface
{
    // Implement methods: createInvoice, getInvoice, verifyWebhook, processCallback
}
```

2. **Update Factory:**
```php
// app/Services/PaymentGateway/PaymentGatewayFactory.php
return match ($provider) {
    'xendit' => new XenditPaymentGateway(),
    'midtrans' => new MidtransPaymentGateway(), // Add here
    // ...
};
```

3. **Update Config:**
```env
PAYMENT_GATEWAY_PROVIDER=midtrans
```

4. **Update `.env`** dengan credentials provider baru

---

## 3. Booking & Payment Flow

### User Flow:
1. User memilih psychologist
2. User memilih waktu dan jenis konsultasi (Online/Offline)
3. User memilih package
4. Sistem membuat invoice via Payment Gateway
5. User dibawa ke halaman pembayaran
6. Setelah pembayaran berhasil (via webhook callback):
   - Appointment dibuat dengan status `Pending`
   - Order payment status diupdate ke `Paid`

### Doctor Flow (Approve & Generate Meeting Link):
1. Psychologist login ke Filament dashboard
2. Buka appointment yang perlu di-approve
3. Change status dari `Pending` ke `Approved`
4. Jika `is_online = true`:
   - Sistem otomatis generate Zoom meeting link
   - Link tersimpan di `meet_url`
5. Patient bisa melihat link di dashboard mereka

---

## 4. File Structure

### New Files Created:

```
app/Services/
├── VideoConferencing/
│   ├── VideoConferencingInterface.php
│   ├── ZoomService.php
│   ├── GoogleMeetService.php
│   └── VideoConferencingFactory.php
└── PaymentGateway/
    ├── PaymentGatewayInterface.php
    ├── XenditPaymentGateway.php
    └── PaymentGatewayFactory.php
```

### Modified Files:
- `app/Http/Controllers/AppointmentController.php` - Updated untuk menggunakan PaymentGatewayFactory
- `app/Filament/Resources/AppointmentResource.php` - Updated meet_url field behavior
- `app/Filament/Resources/AppointmentResource/Pages/EditAppointment.php` - Auto-generate meeting link
- `config/services.php` - Added Zoom, Google Meet, dan Payment Gateway config

---

## 5. Testing

### Test Zoom Integration:
1. Buat appointment dengan `is_online = true`
2. Login sebagai psychologist
3. Approve appointment
4. Check logs untuk confirm meeting link generated
5. Verify `meet_url` field terisi di database

### Test Payment Gateway:
1. Buat booking via website
2. Check invoice created
3. Simulate payment callback (atau pay via Xendit sandbox)
4. Verify appointment created setelah payment success

---

## 6. Environment Variables Summary

```env
# Zoom API
ZOOM_API_KEY=
ZOOM_API_SECRET=
ZOOM_ACCOUNT_ID=
ZOOM_CLIENT_SECRET=
ZOOM_USER_ID=me

# Google Meet API (Optional)
GOOGLE_MEET_ACCESS_TOKEN=
GOOGLE_MEET_CLIENT_ID=
GOOGLE_MEET_CLIENT_SECRET=

# Video Conference Provider
VIDEO_CONFERENCE_PROVIDER=zoom

# Payment Gateway
XENDIT_SECRET_KEY=
XENDIT_WEBHOOK_SECRET=
PAYMENT_GATEWAY_PROVIDER=xendit
```

---

## 7. Troubleshooting

### Zoom Meeting Link Tidak Ter-generate:
- Check Zoom API credentials di `.env`
- Check logs untuk error messages
- Verify appointment `is_online = true` dan status changed ke `Approved`
- Pastikan Zoom API account memiliki permission untuk create meetings

### Payment Callback Tidak Berfungsi:
- Verify webhook URL configured di Xendit dashboard
- Check webhook secret matches dengan `.env`
- Check route `/booking/callback` accessible
- Verify CSRF token disabled untuk callback route (sudah dihandle di `routes/web.php`)

---

## 8. Future Enhancements

- [ ] Add support untuk multiple video conferencing providers (Google Meet fully implemented)
- [ ] Add support untuk multiple payment gateways (Midtrans, Doku, dll)
- [ ] Email notifications ketika meeting link generated
- [ ] SMS notifications untuk appointment reminders
- [ ] Meeting recording integration
- [ ] Calendar integration (Google Calendar, Outlook)

---

## Support

Untuk pertanyaan atau issues, silakan buat issue di repository atau hubungi developer.

