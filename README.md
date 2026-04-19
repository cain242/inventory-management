# Envanter Yönetim Sistemi

Bir şirket veya kurumdaki fiziksel varlıkların (laptop, yazılım lisansı, ofis ekipmanı) kayıt altına alınması, zimmetlenmesi ve personelden gelen taleplerin yönetilmesi için geliştirilen web uygulaması.

## 🧱 Teknoloji Yığını

| Katman | Teknoloji |
|---|---|
| Backend | CodeIgniter 4.7.2 |
| Auth | codeigniter4/shield ^1.2 |
| Veritabanı | MySQL (MySQLi driver) |
| Frontend CSS | Tailwind CSS v4 |
| Build | Vite + @tailwindcss/vite |

## 👥 Takım ve Haftalık Görev Dağılımı

| Hafta | Sorumlu | Modül |
|---|---|---|
| 1 | Öğrenci 1 | Çekirdek yapı ve kimlik yönetimi |
| 2 | Öğrenci 2 | Envanter ve varlık kataloglama |
| 3 | Öğrenci 3 | Talep ve iş akış modülü |
| 4 | Öğrenci 4 | Onay mekanizması ve zimmet yönetimi |
| 5 | Öğrenci 5 | Raporlama, dashboard ve API |

---

## 🚀 Kurulum

### Ön Gereksinimler
- PHP >= 8.1 (intl, mbstring, json, mysqlnd extensions aktif)
- MySQL >= 5.7
- Composer
- Node.js >= 18

### 1. Composer bağımlılıklarını kur

```bash
composer install
```

Bu komut CodeIgniter 4.7.2, Shield ve diğer paketleri `vendor/` klasörüne indirir.

### 2. CodeIgniter'ın system dosyalarını public'e al

`composer install` sonrası CI4'ün `public/index.php` ve `spark` dosyaları otomatik yerleşir. Yerleşmediyse:

```bash
cp vendor/codeigniter4/framework/public/index.php public/index.php
cp vendor/codeigniter4/framework/spark ./spark
```

### 3. NPM paketlerini kur

```bash
npm install
```

### 4. Ortam dosyasını hazırla

```bash
cp .env.example .env
```

`.env` dosyasını aç ve veritabanı bilgilerini gir.

### 5. Veritabanını oluştur

MySQL'de `envanter_db` adında bir veritabanı oluştur (phpMyAdmin veya CLI ile).

```sql
CREATE DATABASE envanter_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Migration'ları çalıştır ve test verileri oluştur

```bash
# Tüm migration'ları çalıştır (Shield tabloları + proje tabloları)
php spark migrate --all

# Test kullanıcılarını oluştur (1 admin + 1 staff)
php spark db:seed DatabaseSeeder
```

> **Not:** `--all` parametresi hem Shield'in kendi tablolarını (users, auth_identities, auth_groups_users vb.) hem de projenin tablolarını (categories vb.) oluşturur.

### 7. Geliştirme sunucularını başlat

İki terminal açıp paralel çalıştır:

```bash
# Terminal 1 — CodeIgniter dev server
## port 8080 kalabalik oldugu icin php spark serve --port 8081 icin composer alias komutuna gecildi kolaylik icin
composer serve
```

```bash
# Terminal 2 — Vite dev server (HMR)
npm run dev
```

Tarayıcıda: **http://localhost:8081**

### Test Hesapları

| Rol | E-posta | Şifre |
|---|---|---|
| Admin | admin@envanter.local | Admin123! |
| Staff | personel1@envanter.local | Staff123! |

---

## 🏗️ Proje Yapısı

```
app/
├── Config/
│   ├── Auth.php          → Shield ana yapılandırması
│   ├── AuthGroups.php    → Grup ve izin tanımları (admin/staff)
│   ├── AuthToken.php     → API token yapılandırması (Hafta 5)
│   ├── Autoload.php      → Helper'lar (auth, setting, vite)
│   ├── Events.php        → Session köprüsü (login/logout event'leri)
│   ├── Filters.php       → auth ve admin filter alias'ları
│   └── Routes.php        → Tüm rotalar (haftalık bloklar)
├── Controllers/
│   ├── AuthController.php → Login/Logout (Shield servisi kullanır)
│   ├── BaseController.php → Ortak controller, auth() ile currentUser
│   ├── Home.php           → Giriş yönlendirme (role göre)
│   ├── Admin/             → Sadece admin grubunun erişebildiği
│   ├── Staff/             → Sadece staff grubunun erişebildiği
│   └── Api/               → JSON endpoint'ler (Hafta 5)
├── Entities/
│   └── User.php           → Shield User entity'si (genişletilebilir)
├── Filters/
│   ├── AuthFilter.php     → Giriş kontrolü (auth()->loggedIn())
│   └── AdminFilter.php    → Admin grubu kontrolü (inGroup('admin'))
├── Helpers/
│   └── vite_helper.php    → Vite asset yükleme
├── Models/
│   └── UserModel.php      → Shield UserModel'i genişletir
├── Database/
│   ├── Migrations/        → Tablo şemaları
│   └── Seeds/             → Test verileri (Shield API ile)
└── Views/
    ├── layouts/main.php   → Ana layout (Tailwind + Vite)
    ├── components/        → Navbar, flash mesajları
    ├── auth/login.php     → Giriş sayfası
    ├── admin/             → Admin sayfaları
    └── staff/             → Personel sayfaları

resources/
├── css/app.css            → Tailwind v4 giriş dosyası
└── js/app.js              → JS bundle kaynakları

public/
├── build/                 → Vite production çıktısı (git'e gitmez)
└── uploads/inventory/     → Envanter görselleri (Hafta 2)
```

---

## 🛣️ Rota Mimarisi

- `/` → Giriş yapmışsa role göre yönlendirir, yapmamışsa `/login`
- `/login`, `/logout` → Özel AuthController (Shield servisi arka planda)
- `/admin/*` → Sadece `admin` grubu (`admin` filter)
- `/staff/*` → Sadece `staff` grubu (giriş gerekli)
- `/api/*` → JSON endpoint'ler (Hafta 5)

---

## 🔑 Kimlik Doğrulama ve Yetkilendirme

### Shield Entegrasyonu

Shield'in **groups** sistemi kullanılıyor:
- `admin` → Envanter, kategori, talep onayı, zimmet, raporlar
- `staff` → Talep oluşturma ve kendi taleplerini görme

### Session Köprüsü

Shield kendi session yönetimini kullanır. Haftalık görevlerde kolaylık için login event'inde ek session değişkenleri set edilir:

```php
// Bu değişkenler otomatik olarak login sonrası set edilir (Events.php)
session()->get('user_id')    // Giriş yapan kullanıcının ID'si
session()->get('role')       // 'admin' veya 'staff'
session()->get('username')   // Kullanıcı adı
session()->get('isLoggedIn') // true

// Shield native erişim de her zaman çalışır:
auth()->user()               // User entity (obje)
auth()->id()                 // Kullanıcı ID
auth()->user()->inGroup('admin')  // Grup kontrolü
```

---

## 📅 Haftalık Checkpoint'ler

Her hafta sonunda şunlar hazır olmalı:
- Kod GitHub'a push edilmiş
- Migration'lar çalışır durumda
- İlgili modül sunum demosu verilebilir

---

## ⚠️ Ortak Kurallar

1. **Çekirdek kodlara dokunma:** AuthController, Filters klasörü, BaseController, Events.php ve Config/Auth*.php dosyalarındaki Hafta 1 kodlarına dokunmayın.
2. **Route eklerken:** Routes.php içinde yorum satırlarıyla belirtilen ilgili haftanın bloğu içine yazın.
3. **Veritabanı değişiklikleri:** Eksik tablo/sütun fark ederseniz doğrudan veritabanına müdahale etmeyin, ilgili haftanın Migration dosyasına yazın.

---

## 🆘 Sorun Giderme

**Migration hatası:** `.env`'deki DB bilgilerini kontrol et, `envanter_db` oluşturulmuş mu?

**Shield tabloları eksik:** `php spark migrate --all` komutunda `--all` parametresini unutma. Bu parametre Shield'in vendor içindeki migration'larını da çalıştırır.

**Vite bağlanamıyor:** `npm run dev`'in çalıştığından ve 5173 portunun açık olduğundan emin ol.

**Helper bulunamıyor (auth/setting):** `composer install` sonrası `vendor/` oluştu mu? Shield bu helper'ları sağlar.

**CSRF hatası:** `.env`'de `security.csrfProtection = 'session'` olmalı.
