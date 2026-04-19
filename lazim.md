HOPPP

1.hafta tamam  ve ayakta. 2., 3., 4. ve 5. haftaların dosya iskeletleri de hazırlandı. 


SU AN NELER HAZIR (1. Hafta - Çekirdek Yapı)
Sistemin temeli  atıldı. Üzerine inşa edeceğiniz yapı şu şekilde çalışıyor:

* Veritabanı ve Tablolar: 'users', 'categories' ve Shield'in tabloları hazır. 'users' tablosunu Shield yönetiyor (şifreler auth_identities tablosunda).
* Kimlik Doğrulama (Auth): CodeIgniter Shield kütüphanesi entegre edildi. Özel login sistemimiz var. Başarıyla giriş yapan kullanıcının verileri Shield tarafından yönetilirken, geriye dönük uyumluluk için 'user_id' ve 'role' bilgileri session'a da kaydediliyor (Events ile).
* Yetkilendirme (Middleware/Filters): Admin ve Staff (Personel) sayfalarının güvenliği sağlandı. Staff yetkisindeki biri asla Admin sayfalarına giremez.
* Tasarım (UI): Tailwind CSS ve Vite entegrasyonu tamamlandı. Ana layout (Views/layouts/main.php) ve Navbar dinamik olarak çalışıyor.


GÖREV DAĞILIMI VE ETKİLEŞİM REHBERİ

2. HAFTA: Envanter ve Varlık Kataloglama
Sistemin "içeriğini" yönetecek modülü yazmak. Sisteme donanım/yazılım ekleme, listeleme ve fotoğraf yükleme işlemleri sende.

* Çalışacağın Dosyalar:
  - Controllers/Admin/CategoryController.php & InventoryController.php
  - Models/CategoryModel.php & InventoryModel.php
  - Views/admin/categories/ ve Views/admin/inventory/ içindeki sayfalar.
* yapılacaklar:
  - Kategoriler (Donanım, Yazılım vb.) için CRUD (Ekle, Sil, Güncelle, Listele) işlemlerini yazacaksın.
  - Envanter kaydı formu oluşturacaksın (Ürün adı, seri no, alım tarihi, durum). Durumlar "boşta, kullanımda, arızalı" olacak.
  - Ürünlere fotoğraf yükleme işlemini (Görsel Yönetimi) yapacaksın.
  - Marka/Kategori bazlı arama ve filtreleme yazacaksın.
* Nereyle Etkileşimde Olacaksın: 
  - Senin eklediğin ürünler, 3. haftadaki arkadaşın "Talep Formu"nda listelenecek. 
  - Kategori tablosu halihazırda 1. haftada oluşturuldu, onu kullanacaksın.


3. HAFTA: Talep ve İş Akış Modülü
yapılacaklar: Sistemin etkileşimli kısmı. Personelin (Staff), yönetimden (Admin) yeni cihaz istemesi veya bozulan cihazı bildirmesini sağlayacaksın.

* Çalışacağın Dosyalar:
  - Controllers/Staff/RequestController.php
  - Models/RequestModel.php
  - Views/staff/requests/ içindeki sayfalar.
* Neler Yapacaksın:
  - Personel arayüzünde "Arıza Bildirimi" veya "Yeni Ekipman Talebi" oluşturmak için form tasarlayacaksın.
  - Bu formdaki verilerin boş bırakılamayacağı gibi kuralları (Validasyon) yazacaksın.
  - Personelin sadece kendi oluşturduğu talepleri görebileceği bir liste sayfası yapacaksın.
* Nereyle Etkileşimde Olacaksın:
  - KRİTİK: Talebin kim tarafından yapıldığını bulmak için 1. haftada kurulan session()->get('user_id') bilgisini kullanacaksın. Asla kullanıcıdan adını formda girmesini isteme; sistem bunu arka planda session'dan çekmeli.
  - Talebin hangi ürün için yapıldığını bulmak için 2. haftada oluşturulan inventory tablosundaki verileri çekeceksin.


4. HAFTA: Onay Mekanizması ve Zimmet Yönetimi
yapılacaklar: Adminin karar verme süreçleri. 3. haftadan gelen talepleri değerlendirip, cihazları personele atayacaksın.

* Çalışacağın Dosyalar:
  - Controllers/Admin/RequestController.php & AssignmentController.php
  - Models/AssignmentModel.php
  - Views/admin/requests/ ve Views/admin/assignments/ içindeki sayfalar.
* Neler Yapacaksın:
  - Bekleyen talepleri listeyen bir "Admin Onay Paneli" yapacaksın.
  - Taleplere "Onayla", "Reddet" butonları koyacak ve açıklama yazma alanı ekleyeceksin.
  - Zimmetleme İşlemi: Bir cihaz onaylandığında, o cihazın durumunu "kullanımda" olarak güncelleyecek ve o cihazı talep eden kullanıcıya bağlayacaksın (Zimmet).
* Nereyle Etkileşimde Olacaksın:
  - Senin modülün tam bir köprü. 3. haftanın ürettiği talepleri okuyacaksın, 2. haftanın ürettiği envanterlerin "durum" sütununu değiştireceksin.


5. HAFTA: Raporlama, Dashboard ve API 
yapılacaklar: Projenin vitrini. Yönetici özet ekranını ve grafikleri oluşturup projeyi sonlandıracaksın.

* Çalışacağın Dosyalar:
  - Controllers/Admin/DashboardController.php (Güncellenecek)
  - Controllers/Api/DashboardApi.php
  - Views/admin/dashboard.php
* Neler Yapacaksın:
  - Admin ana ekranında (Dashboard) "Toplam Envanter Sayısı", "Bekleyen Talep Sayısı" gibi özet kartları oluşturacaksın.
  - Chart.js kullanarak "Kategori Bazlı Stok Dağılımı" grafiği çizeceksin.
  - Grafiklerin verilerini sayfa yenilenmeden çekebilmek için bir JSON API ucu (DashboardApi.php) yazacaksın.
* Nereyle Etkileşimde Olacaksın:
  - Sen herkesin verisini okuyacaksın. Tüm tablolarla (inventory, requests, categories) bağlantı kurup count() ve group_by() gibi SQL/Model sorguları yazacaksın.

--------------------------------------------------

Ortak Kurallar:
*  kimse AuthController, Filters klasörü, BaseController veya Config içindeki Auth ve Events dosyalarına (1. Hafta çekirdek kodları) dokunmasın.
* Rotanızı (Routes.php) eklerken yorum satırlarıyla belirtilen ilgili haftanın bloğu içine yazın.
* Veritabanında eksik bir tablo/sütun fark ederseniz doğrudan veritabanına müdahale etmeyin, ilgili haftanın Migration dosyasına yazın.

öpüldünüz muck