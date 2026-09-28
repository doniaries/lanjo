# Website Dinas Pariwisata, Pemuda dan Olahraga Kabupaten Sijunjung

![Laravel](https://img.shields.io/badge/Laravel-11.x-red)
![Filament](https://img.shields.io/badge/Filament-4.x-orange)
![Livewire](https://img.shields.io/badge/Livewire-3.x-pink)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-blue)

Website resmi Dinas Pariwisata, Pemuda dan Olahraga Kabupaten Sijunjung yang menyediakan informasi pariwisata, berita, pengumuman, agenda kegiatan, dan layanan publik.

🌐 **Domain**: [disparpora.sijunjung.go.id](https://disparpora.sijunjung.go.id)

---

## 📋 Daftar Isi

- [Tentang Aplikasi](#tentang-aplikasi)
- [Fitur Utama](#fitur-utama)
- [Modul & Dokumentasi](#modul--dokumentasi)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Instalasi](#instalasi)
- [Konfigurasi](#konfigurasi)
- [Deployment](#deployment)
- [Kontributor](#kontributor)

---

## 🎯 Tentang Aplikasi

Website ini dibangun untuk memberikan layanan informasi publik yang transparan dan mudah diakses oleh masyarakat Kabupaten Sijunjung. Aplikasi ini menggabungkan sistem manajemen konten (CMS) yang powerful dengan tampilan frontend yang modern dan responsif.

### Tujuan
- Menyediakan informasi pariwisata Kabupaten Sijunjung
- Memberikan transparansi informasi publik
- Memudahkan akses layanan dan dokumen
- Mempromosikan destinasi wisata lokal
- Meningkatkan engagement dengan masyarakat

---

## ✨ Fitur Utama

### Frontend (Public)
- 🏠 **Halaman Depan** - Landing page dengan slider banner dan informasi terkini
- 📰 **Berita** - Artikel berita dengan kategori dan pencarian
- 📢 **Pengumuman** - Informasi pengumuman resmi
- 📅 **Agenda Kegiatan** - Jadwal kegiatan dan acara
- 🏞️ **Wisata** - Katalog destinasi wisata dengan galeri foto
- 📄 **Dokumen** - Repository dokumen publik
- 🖼️ **Galeri** - Galeri foto dan video
- 🔗 **External Links** - Tautan ke website terkait
- 👥 **Struktur Organisasi** - Informasi struktur organisasi dinas
- 💬 **Sambutan Pimpinan** - Sambutan dari Kepala Dinas
- 🌓 **Dark Mode** - Tema gelap/terang

### Backend (Admin Panel)
- 🔐 **Authentication** - Login dengan role-based access
- 📊 **Dashboard** - Statistik dan overview
- ✍️ **Content Management** - Kelola semua konten
- 👤 **User Management** - Kelola pengguna dan role
- ⚙️ **Settings** - Pengaturan website
- 📈 **Analytics** - Statistik pengunjung

---

## 📚 Modul & Dokumentasi

### 1. **Halaman Depan**
**Path**: `/`

**Fitur**:
- Hero section dengan slider banner dinamis
- Section berita terbaru (6 artikel)
- Section wisata unggulan (6 destinasi)
- Section pengumuman terbaru
- Section agenda kegiatan mendatang
- External links ke website terkait
- Sambutan pimpinan
- Footer dengan informasi kontak

**Admin Panel**: 
- Atur konten sambutan di menu `Sambutan Pimpinan`
- Kelola external links di menu `External Link`

---

### 2. **Berita**
**Path**: `/berita`

**Fitur**:
- Listing berita dengan pagination
- Filter berdasarkan tag/kategori
- Pencarian berita
- Detail berita dengan foto utama dan gallery
- Caption untuk foto utama dan gallery
- Source link untuk berita saduran
- View counter
- Featured posts
- Related posts
- Dark mode support

**Admin Panel**: 
- Menu `Posts` untuk kelola berita
- Upload foto utama dengan caption
- Gallery dengan multiple foto dan caption
- Rich text editor untuk konten
- Tag management
- Status: draft/published
- Featured toggle
- SEO-friendly slug

**Model**: `Post`  
**Controller**: `BeritaIndex`, `BeritaDetail`  
**Views**: 
- `resources/views/livewire/berita-index.blade.php`
- `resources/views/livewire/berita-detail.blade.php`

---

### 3. **Pengumuman**
**Path**: `/pengumuman`

**Fitur**:
- Listing pengumuman dengan pagination
- Pencarian pengumuman
- Detail pengumuman
- Lampiran file (PDF, DOC, dll)
- Tanggal publikasi
- Dark mode support

**Admin Panel**: 
- Menu `Pengumuman` untuk kelola pengumuman
- Upload file lampiran
- Rich text editor
- Status publikasi

**Model**: `Pengumuman`  
**Controller**: `PengumumanIndex`  
**Views**: `resources/views/livewire/pengumuman-index.blade.php`

---

### 4. **Agenda Kegiatan**
**Path**: `/agenda`

**Fitur**:
- Listing agenda dengan pagination
- Filter berdasarkan bulan/tahun
- Detail agenda kegiatan
- Informasi waktu, tempat, penyelenggara
- Countdown untuk agenda mendatang
- Dark mode support

**Admin Panel**: 
- Menu `Agenda Kegiatan` untuk kelola agenda
- Input tanggal mulai dan selesai
- Input waktu mulai dan selesai
- Input tempat dan penyelenggara
- Rich text editor untuk deskripsi

**Model**: `AgendaKegiatan`  
**Controller**: `AgendaKegiatan`  
**Views**: `resources/views/livewire/agenda-kegiatan.blade.php`

---

### 5. **Wisata**
**Path**: `/wisata`

**Fitur**:
- Listing destinasi wisata dengan grid layout
- Pencarian wisata
- Detail wisata dengan:
  - Foto utama dan gallery
  - Caption untuk setiap foto
  - Deskripsi lengkap
  - Fasilitas
  - Jam operasional
  - Harga tiket
  - Lokasi (alamat)
  - Kontak
- Lightbox untuk gallery
- Dark mode support

**Admin Panel**: 
- Menu `Tempat Wisata` untuk kelola destinasi
- Upload foto utama
- Gallery dengan repeater (foto + caption)
- Rich text editor untuk deskripsi
- Input fasilitas, jam operasional, harga
- Input lokasi dan kontak

**Model**: `TempatWisata`  
**Controller**: `WisataIndex`, `WisataDetail`  
**Views**: 
- `resources/views/livewire/wisata-index.blade.php`
- `resources/views/livewire/wisata-detail.blade.php`

---

### 6. **Dokumen**
**Path**: `/dokumen`

**Fitur**:
- Listing dokumen dengan pagination
- Filter berdasarkan kategori
- Pencarian dokumen
- Download dokumen
- Preview untuk PDF
- Dark mode support

**Admin Panel**: 
- Menu `Dokumen` untuk kelola dokumen
- Upload file (PDF, DOC, XLS, dll)
- Kategori dokumen
- Deskripsi dokumen

**Model**: `Dokumen`  
**Controller**: `DokumenIndex`  
**Views**: `resources/views/livewire/dokumen-index.blade.php`

---

### 7. **Galeri**
**Path**: `/galeri`

**Fitur**:
- Grid layout untuk foto/video
- Lightbox untuk preview
- Filter berdasarkan kategori
- Pencarian galeri
- Support foto dan video
- Dark mode support

**Admin Panel**: 
- Menu `Gallery` untuk kelola galeri
- Upload foto/video
- Kategori galeri
- Caption untuk setiap item

**Model**: `Gallery`  
**Controller**: `GalleryIndex`  
**Views**: `resources/views/livewire/gallery-index.blade.php`

---

### 8. **Struktur Organisasi**
**Path**: `/struktur-organisasi`

**Fitur**:
- Tampilan struktur organisasi
- Foto dan informasi pejabat
- Jabatan dan kontak
- Dark mode support

**Admin Panel**: 
- Menu `Struktur Organisasi` untuk kelola struktur
- Upload foto pejabat
- Input nama, jabatan, kontak

**Model**: `StrukturOrganisasi`  
**Controller**: `StrukturOrganisasi`  
**Views**: `resources/views/livewire/struktur-organisasi.blade.php`

---

### 9. **Sambutan Pimpinan**
**Path**: `/sambutan-pimpinan`

**Fitur**:
- Sambutan dari Kepala Dinas
- Foto pimpinan
- Biodata singkat
- Dark mode support

**Admin Panel**: 
- Menu `Sambutan Pimpinan` untuk kelola sambutan
- Upload foto pimpinan
- Rich text editor untuk sambutan
- Input nama dan jabatan

**Model**: `SambutanPimpinan`  
**Controller**: `SambutanPimpinan`  
**Views**: `resources/views/livewire/sambutan-pimpinan.blade.php`

---

### 10. **Pengaturan**
**Path**: `/admin/pengaturan`

**Fitur**:
- Pengaturan umum website
- Logo instansi
- Informasi kontak
- Social media links
- Alamat kantor
- Jam operasional

**Admin Panel**: 
- Menu `Pengaturan` untuk kelola setting
- Upload logo
- Input informasi kontak
- Input social media

**Model**: `Pengaturan`

---


- Urutan tampilan
- Status aktif/nonaktif

**Admin Panel**: 
- Upload gambar (recommended: 1920x600px)
- Input link (opsional)
- Drag & drop untuk urutan


---

### 12. **Infografis**
**Path**: `/admin/infografis`

**Fitur**:
- Upload infografis
- Kategori infografis
- Deskripsi

**Admin Panel**: 
- Menu `Infografis` untuk kelola infografis
- Upload gambar infografis
- Input kategori dan deskripsi

**Model**: `Infografis`

---

### 13. **External Links**
**Path**: `/admin/external-links`

**Fitur**:
- Tautan ke website terkait
- Logo/icon website
- Deskripsi singkat
- Urutan tampilan

**Admin Panel**: 
- Menu `External Link` untuk kelola link
- Upload logo
- Input URL dan deskripsi
- Drag & drop untuk urutan

**Model**: `ExternalLink`

---

### 14. **Layanan**
**Path**: `/admin/layanan`

**Fitur**:
- Informasi layanan publik
- Deskripsi layanan
- Persyaratan
- Prosedur
- Waktu penyelesaian

**Admin Panel**: 
- Menu `Layanan` untuk kelola layanan
- Rich text editor untuk deskripsi
- Input persyaratan dan prosedur

**Model**: `Layanan`

---

### 15. **User Management**
**Path**: `/admin/users`

**Fitur**:
- Kelola pengguna admin
- Role-based access control
- Permission management
- Filament Shield integration

**Admin Panel**: 
- Menu `Users` untuk kelola user
- Menu `Roles` untuk kelola role
- Menu `Permissions` untuk kelola permission

**Model**: `User`

---

## 🛠️ Teknologi yang Digunakan

### Backend
- **Laravel 11.x** - PHP Framework
- **Filament 4.x** - Admin Panel
- **Livewire 3.x** - Full-stack framework
- **Spatie Permission** - Role & Permission management
- **Filament Shield** - Role management untuk Filament

### Frontend
- **TailwindCSS 3.x** - CSS Framework
- **Alpine.js** - JavaScript framework
- **Blade** - Template engine
- **Vite** - Asset bundler

### Database
- **MySQL** - Database

### Tools & Libraries
- **Laravel Telescope** - Debugging tool
- **Intervention Image** - Image manipulation
- **Laravel Sluggable** - Auto slug generation

---

## 📦 Instalasi

### Requirements
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL >= 8.0

### Langkah Instalasi

1. **Clone repository**
```bash
git clone [repository-url]
cd parpora
```

2. **Install dependencies**
```bash
composer install
npm install
```

3. **Setup environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi database**

Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=parpora
DB_USERNAME=root
DB_PASSWORD=
```

5. **Migrasi database**
```bash
php artisan migrate
```

6. **Seed data (opsional)**
```bash
php artisan db:seed
```

7. **Create storage link**
```bash
php artisan storage:link
```

8. **Build assets**
```bash
npm run build
```

9. **Jalankan aplikasi**
```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

---

## ⚙️ Konfigurasi

### Admin Panel

**Default Admin Credentials** (setelah seeding):
- Email: `admin@example.com`
- Password: `password`

**Akses Admin Panel**: `/admin`

### File Upload

Konfigurasi upload di `config/filesystems.php`:
- **Storage**: `storage/app/public`
- **Max size**: 2MB untuk gambar, 10MB untuk dokumen
- **Allowed types**: 
  - Images: jpg, jpeg, png, gif, webp
  - Documents: pdf, doc, docx, xls, xlsx
  - Videos: mp4, avi, mov

### Cache

Clear cache:
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

---

## 🚀 Deployment

### Production Setup

1. **Set environment to production**
```env
APP_ENV=production
APP_DEBUG=false
```

2. **Optimize aplikasi**
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. **Set permissions**
```bash
chmod -R 755 storage bootstrap/cache
```

4. **Setup cron job**

Tambahkan ke crontab:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

### Server Requirements
- PHP 8.2+
- MySQL 8.0+
- Nginx/Apache
- SSL Certificate (Let's Encrypt)

---

## 👥 Kontributor

**Dinas Pariwisata, Pemuda dan Olahraga Kabupaten Sijunjung**

- **Kepala Dinas**: Afrineldi, SH
- **Developer**: Success Mandiri Team

---

## 📝 License

Aplikasi ini dikembangkan untuk Pemerintah Kabupaten Sijunjung.

---

## 📞 Kontak

**Dinas Pariwisata, Pemuda dan Olahraga Kabupaten Sijunjung**

- 🌐 Website: [parpora.sijunjung.go.id](https://parpora.sijunjung.go.id)
- 📧 Email: disparpora@sijunjungkab.go.id
- 📱 Telepon: (0754) 21XXX
- 📍 Alamat: Gedung Bersama, Kabupaten Sijunjung

---

**© 2026 Dinas Pariwisata, Pemuda dan Olahraga Kabupaten Sijunjung**
# disparpora.sijunjung.go.id
# disparpora.sijunjung.go.id
