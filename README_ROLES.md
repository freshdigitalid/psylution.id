# Role-Based User System

## Overview

Sistem user telah dipisahkan berdasarkan role dengan menggunakan tabel terpisah untuk roles dan foreign key relationship.

## Struktur Database

### Tabel `roles`

- `id` - Primary key
- `name` - Nama role (admin, psychologist, patient)
- `display_name` - Nama yang ditampilkan (Admin, Psychologist, Patient)
- `description` - Deskripsi role
- `created_at`, `updated_at` - Timestamps

### Tabel `users`

- `id` - Primary key
- `name` - Nama user
- `email` - Email user (unique)
- `email_verified_at` - Timestamp verifikasi email
- `avatar` - Avatar user
- `password` - Password yang di-hash
- `role_id` - Foreign key ke tabel roles
- `remember_token` - Token untuk remember me
- `deleted_at` - Soft delete timestamp
- `created_at`, `updated_at` - Timestamps

## Role yang Tersedia

### 1. Admin

- **Name**: `admin`
- **Display Name**: `Admin`
- **Description**: Administrator dengan akses penuh ke semua fitur
- **Panel Filament**: `/admin`

### 2. Psychologist

- **Name**: `psychologist`
- **Display Name**: `Psychologist`
- **Description**: Psikolog dengan akses ke manajemen pasien dan sesi terapi
- **Panel Filament**: `/psychologist`

### 3. Patient

- **Name**: `patient`
- **Display Name**: `Patient`
- **Description**: Pasien dengan akses ke dashboard pribadi dan sesi terapi
- **Panel Filament**: `/patient`

## Seeder yang Tersedia

### RoleSeeder

Membuat role dasar (admin, psychologist, patient)

### AdminUserSeeder

Membuat user admin:

- Email: `admin@psylution.id`
- Password: `password`
- Email: `superadmin@psylution.id`
- Password: `password`

### PatientUserSeeder

Membuat user patient:

- Email: `patient@psylution.id`
- Password: `password`
- Email: `john.doe@example.com`
- Password: `password`
- Email: `jane.smith@example.com`
- Password: `password`

### PsychologistUserSeeder

Membuat user psychologist:

- Email: `psychologist@psylution.id`
- Password: `password`
- Email: `sarah.johnson@psylution.id`
- Password: `password`
- Email: `michael.chen@psylution.id`
- Password: `password`

## Cara Menjalankan

### Migrasi dan Seeder

```bash
# Jalankan migrasi
php artisan migrate

# Jalankan seeder
php artisan db:seed
```

### Jalankan Seeder Tertentu

```bash
# Jalankan role seeder saja
php artisan db:seed --class=RoleSeeder

# Jalankan admin seeder saja
php artisan db:seed --class=AdminUserSeeder

# Jalankan patient seeder saja
php artisan db:seed --class=PatientUserSeeder

# Jalankan psychologist seeder saja
php artisan db:seed --class=PsychologistUserSeeder
```

## Panel Filament

Setiap role memiliki panel Filament terpisah:

1. **Admin Panel**: `/admin`
    - Provider: `AdminPanelProvider`
    - Resources: `app/Filament/Resources`
    - Pages: `app/Filament/Pages`
    - Widgets: `app/Filament/Widgets`

2. **Patient Panel**: `/patient`
    - Provider: `PatientPanelPanelProvider`
    - Resources: `app/Filament/PatientPanel/Resources`
    - Pages: `app/Filament/PatientPanel/Pages`
    - Widgets: `app/Filament/PatientPanel/Widgets`

3. **Psychologist Panel**: `/psychologist`
    - Provider: `PsychologistPanelPanelProvider`
    - Resources: `app/Filament/PsychologistPanel/Resources`
    - Pages: `app/Filament/PsychologistPanel/Pages`
    - Widgets: `app/Filament/PsychologistPanel/Widgets`

## Model Relationships

### User Model

```php
// Relationship dengan Role
public function role()
{
    return $this->belongsTo(Role::class);
}

// Access panel berdasarkan role
public function canAccessPanel(Panel $panel): bool
{
    return (
        ($this->role->name === 'admin' && $panel->getId() === 'admin') ||
        ($this->role->name === 'patient' && $panel->getId() === 'patient') ||
        ($this->role->name === 'psychologist' && $panel->getId() === 'psychologist')
    );
}
```

### Role Model

```php
// Relationship dengan User
public function users()
{
    return $this->hasMany(User::class);
}

// Helper methods
public function isAdmin(): bool
public function isPsychologist(): bool
public function isPatient(): bool
```

## Keuntungan Sistem Baru

1. **Fleksibilitas**: Mudah menambah role baru tanpa mengubah kode
2. **Maintainability**: Role terpisah dari user, lebih mudah dikelola
3. **Scalability**: Bisa menambah permission dan deskripsi untuk setiap role
4. **Security**: Panel Filament terpisah berdasarkan role
5. **Database Integrity**: Foreign key constraint memastikan data konsisten
