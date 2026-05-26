<div align="center">

# 💰 WealthWise

### _Your AI-Powered Personal Finance Manager_

**Kelola keuanganmu lebih cerdas dengan kekuatan Artificial Intelligence**

[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![React](https://img.shields.io/badge/React-19-61DAFB?style=for-the-badge&logo=react&logoColor=black)](https://react.dev)
[![Vite](https://img.shields.io/badge/Vite-8-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)
[![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-v4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Groq](https://img.shields.io/badge/Groq_AI-LLaMA-F55036?style=for-the-badge&logo=meta&logoColor=white)](https://groq.com)

</div>

---

## 🧠 Apa itu WealthWise?

**WealthWise** adalah aplikasi manajemen keuangan pribadi berbasis web yang dilengkapi dengan kecerdasan buatan (AI). Tidak sekadar mencatat pemasukan dan pengeluaran — WealthWise menganalisis kondisi keuanganmu, memberikan insight harian, menjawab pertanyaan lewat chatbot AI, hingga **membaca struk belanja secara otomatis** hanya dengan foto.

---

## ✨ Fitur Unggulan

### 🤖 Fitur AI Canggih

| Fitur                         | Deskripsi                                                                                                   | Model AI                 |
| ----------------------------- | ----------------------------------------------------------------------------------------------------------- | ------------------------ |
| 📸 **OCR Receipt Scanner**    | Foto struk belanjamu → AI langsung mengekstrak merchant, nominal, dan tanggal transaksi secara otomatis     | Llama 4 Scout 17B Vision |
| 💬 **AI Financial Chatbot**   | Tanya apa saja tentang keuanganmu. Chatbot AI menjawab berdasarkan data finansial riil milikmu              | Llama 3.3-70B Versatile  |
| 💡 **AI Daily Insights**      | Setiap hari, AI menganalisis profil keuanganmu dan menghasilkan insight & rekomendasi yang diprioritaskan   | Llama 3.3-70B Versatile  |
| 📊 **Financial Health Score** | Skor kesehatan keuangan (0–100) dihitung otomatis berdasarkan saving ratio, expense ratio, dan dana darurat | Algoritma berbasis AI    |

#### 📸 OCR Receipt Scanner — Cara Kerjanya

```
1. Upload foto struk (jpg/png/webp)  ──►  2. Groq Vision AI menganalisis gambar
                                                         │
3. Transaksi langsung terisi otomatis  ◄──  AI mengekstrak:
   • Nama merchant                              • Nominal (IDR)
   • Nominal                                    • Tanggal
   • Tanggal transaksi                          • Deskripsi pembelian
```

#### 💬 AI Chatbot — Konteks Pribadi

Chatbot WealthWise bukan chatbot generik. Setiap respons dibuat berdasarkan **data keuangan nyata milikmu**:

- Saving Ratio kamu saat ini
- Expense Ratio bulan ini
- Jumlah bulan dana darurat yang tersedia
- Skor Kesehatan Keuangan

---

### 📱 Fitur Aplikasi Lengkap

#### 🏠 Dashboard

- Ringkasan total saldo semua akun
- Grafik pemasukan vs pengeluaran
- 5 transaksi terbaru

#### 💳 Manajemen Akun

- Tambah multiple akun (Bank, E-wallet, Tunai, dll.)
- Pantau saldo per akun secara real-time
- Edit & hapus akun kapan saja

#### 📝 Manajemen Transaksi

- Catat pemasukan & pengeluaran
- Filter & cari transaksi
- Edit dan hapus riwayat transaksi
- **Scan struk otomatis dengan AI** (fitur OCR)

#### 🏷️ Kategori dengan Budget

- Buat kategori kustom (Makan, Transport, Hiburan, dll.)
- Tetapkan batas budget per kategori
- Pantau realisasi budget harian/mingguan/bulanan

#### 🎯 Smart Planning — Target Keuangan

- Buat target tabungan dengan nama & emoji kustom
- Pilih rencana pengisian: **Harian / Mingguan / Bulanan**
- Progress bar visual yang interaktif
- Kalkulasi otomatis nominal per periode
- Tambah/kurangi dana ke goal secara manual

#### 📈 Statistik Visual

- Grafik batang pemasukan per periode
- Pie chart pengeluaran per kategori
- Filter: Harian, Mingguan, Bulanan, Tahunan

#### 💚 Financial Health

- **Saving Ratio** (% pendapatan yang ditabung)
- **Expense Ratio** (% pendapatan yang dibelanjakan)
- **Dana Darurat** (berapa bulan pengeluaran yang aman)
- **Skor Kesehatan Keuangan** 0–100
- AI Insights harian yang dipersonalisasi
- Chatbot finansial interaktif

#### 👤 Profil Pengguna

- Edit nama & informasi profil
- Ganti password secara aman

#### 🔐 Autentikasi

- Register & Login aman (Laravel Sanctum)
- Verifikasi email
- Token-based authentication

---

## 🛠️ Tech Stack

### Backend

| Teknologi               | Versi | Kegunaan                         |
| ----------------------- | ----- | -------------------------------- |
| **PHP**                 | 8.2   | Runtime bahasa                   |
| **Laravel**             | 12    | Framework backend                |
| **Laravel Sanctum**     | 4.0   | API Authentication (token-based) |
| **SQLite / PostgreSQL** | —     | Database                         |
| **Guzzle HTTP**         | —     | HTTP client untuk Groq API       |

### Frontend

| Teknologi            | Versi | Kegunaan                   |
| -------------------- | ----- | -------------------------- |
| **React**            | 19    | UI Library                 |
| **Vite**             | 8     | Build tool & dev server    |
| **Tailwind CSS**     | v4    | Utility-first styling      |
| **React Router DOM** | v7    | Client-side routing        |
| **Recharts**         | 3.x   | Grafik & visualisasi data  |
| **Lucide React**     | —     | Icon library               |
| **Axios**            | —     | HTTP client ke backend API |

### AI & Intelligence

| Teknologi    | Model                                       | Kegunaan                        |
| ------------ | ------------------------------------------- | ------------------------------- |
| **Groq API** | `meta-llama/llama-4-scout-17b-16e-instruct` | OCR Receipt Scanner (Vision AI) |
| **Groq API** | `llama-3.3-70b-versatile`                   | Chatbot AI & Daily Insights     |

### DevOps & Tools

| Teknologi           | Kegunaan                                   |
| ------------------- | ------------------------------------------ |
| **Docker + Apache** | Containerization & deployment              |
| **Composer**        | PHP dependency manager                     |
| **npm / Node.js**   | Frontend dependency manager                |
| **Laravel Pail**    | Real-time log viewer                       |
| **concurrently**    | Jalankan server, queue, dan vite sekaligus |

---

## 🚀 Cara Instalasi

> Pastikan sudah terinstall: **PHP 8.2+**, **Composer**, **Node.js 18+**, dan **Git**

### 1. Clone Repository

```bash
# Backend
git clone <url-repo-backend> WealthWise
cd WealthWise

# Frontend (direktori terpisah)
git clone <url-repo-frontend> WealthWise-Frontend
```

### 2. Setup Backend (Laravel API)

```bash
cd WealthWise

# Install dependency PHP
composer install

# Salin file environment
cp .env.example .env

# Generate app key
php artisan key:generate

# Buat database SQLite
touch database/database.sqlite

# Jalankan migrasi database
php artisan migrate

# Install dependency Node.js
npm install && npm run build
```

### 3. Konfigurasi API Key AI (Groq)

Edit file `.env` dan tambahkan Groq API Key kamu:

```env
GROQ_API_KEY=gsk_xxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

> 🔑 Dapatkan API Key gratis di [console.groq.com](https://console.groq.com)

### 4. Setup Frontend (React)

```bash
cd WealthWise-Frontend/wealthwise-frontend

# Install dependency
npm install

# Salin dan atur environment
cp .env.example .env
# Edit .env: isi VITE_API_URL=http://localhost:8000/api
```

### 5. Jalankan Aplikasi

**Backend** (Terminal 1):

```bash
cd WealthWise
composer run dev
# Atau manual:
# php artisan serve
```

**Frontend** (Terminal 2):

```bash
cd WealthWise-Frontend/wealthwise-frontend
npm run dev
```

Akses aplikasi di: **http://localhost:5173**
Backend API berjalan di: **http://localhost:8000/api**

---

### 🐳 Alternatif: Jalankan dengan Docker

```bash
cd WealthWise

# Build dan jalankan container
docker build -t wealthwise-api .
docker run -p 8000:80 \
  -e APP_KEY=base64:xxxx \
  -e GROQ_API_KEY=gsk_xxxx \
  -e DB_CONNECTION=sqlite \
  wealthwise-api
```

---

## ⚙️ Environment Variables Penting

| Variable        | Contoh Nilai            | Keterangan                                        |
| --------------- | ----------------------- | ------------------------------------------------- |
| `APP_KEY`       | `base64:...`            | Digenerate otomatis dengan `artisan key:generate` |
| `APP_URL`       | `http://localhost:8000` | URL backend                                       |
| `GROQ_API_KEY`  | `gsk_xxx...`            | **Wajib** untuk fitur AI (OCR, Chatbot, Insights) |
| `DB_CONNECTION` | `sqlite`                | Driver database (`sqlite` atau `pgsql`)           |

---

## 📁 Struktur Proyek

```
WealthWise/                          ← Laravel Backend (REST API)
├── app/
│   ├── Http/Controllers/Api/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── TransactionController.php
│   │   ├── FinancialHealthController.php  ← AI Chatbot & Health Score
│   │   ├── ReceiptScanController.php      ← 🤖 OCR AI Scanner
│   │   └── FinancialGoalController.php
│   ├── Services/
│   │   ├── FinancialHealthService.php     ← 🤖 AI Insights Generator
│   │   └── FinancialStatsService.php
│   └── Models/
│       ├── Transaction.php
│       ├── Account.php
│       ├── FinancialGoal.php
│       └── Insight.php                    ← Penyimpanan AI Insights
└── routes/api.php

WealthWise-Frontend/wealthwise-frontend/   ← React Frontend
└── src/
    ├── pages/
    │   ├── dashboard/         ← Halaman utama
    │   ├── financial-health/  ← AI Chatbot & Insights
    │   ├── smartplanning/     ← Target keuangan
    │   ├── statistics/        ← Grafik & chart
    │   ├── transactions/      ← Manajemen transaksi + OCR
    │   └── auth/              ← Login & Register
    └── components/
```

---

## 🔗 API Endpoints Utama

| Method     | Endpoint                     | Fitur                         |
| ---------- | ---------------------------- | ----------------------------- |
| `POST`     | `/api/receipt/scan`          | 🤖 OCR — Scan struk dengan AI |
| `GET`      | `/api/financial-health`      | 🤖 Skor + AI Insights harian  |
| `POST`     | `/api/financial-health/chat` | 🤖 Chatbot AI finansial       |
| `GET`      | `/api/dashboard`             | Ringkasan dashboard           |
| `GET/POST` | `/api/transactions`          | Manajemen transaksi           |
| `GET/POST` | `/api/goals`                 | Smart Planning goals          |
| `GET`      | `/api/statistics`            | Data statistik & grafik       |

---

## 👥 Tim Pengembang

> Dibuat sebagai Tugas Besar Mata Kuliah **Aplikasi Berbasis Platform** — Semester 6

---

<div align="center">

**WealthWise** — _Cerdas Mengelola, Bijak Merencanakan_ 💚

</div>
