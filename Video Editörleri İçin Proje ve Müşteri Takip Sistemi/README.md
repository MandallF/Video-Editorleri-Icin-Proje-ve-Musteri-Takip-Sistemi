# Video Editörleri İçin Proje ve Müşteri Takip Sistemi

## Kurulum

1. MySQL'de `video_edit_project` veritabanını oluşturun ve tabloları aşağıdaki SQL ile oluşturun (database.sql):

CREATE DATABASE IF NOT EXISTS video_edit_project CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE video_edit_project;

CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(50) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE customers (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT NOT NULL,
name VARCHAR(100) NOT NULL,
email VARCHAR(100),
phone VARCHAR(50),
notes TEXT,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

2. `db.php` dosyasındaki veritabanı kullanıcı adı ve şifre bilgilerini kendinize göre düzenleyin.

3. Dosyaları bir PHP sunucusuna yükleyin veya lokal ortamda çalıştırın.

4. `register.php` sayfasından yeni kullanıcı oluşturun.

5. Giriş yapıp müşteri eklemeye başlayabilirsiniz.

---

## Özellikler

- Kullanıcı kayıt, giriş ve çıkış sistemi.
- Kullanıcıya özel müşteri ekleme, listeleme, düzenleme ve silme.
- Basit ve temiz Bootstrap tasarım.

---

## Gereksinimler

- PHP 7.4+
- MySQL 5.7+
- PDO eklentisi aktif olmalı.

##Proje Demo Videosu ve Ekran Görüntüsü:

Demo Videosu: https://youtu.be/8FF2bR9HLzM

![kayıt_ol](https://github.com/user-attachments/assets/f438fdac-d871-4e29-ba0a-5c4dcbb9c0ab)

![yonetim](https://github.com/user-attachments/assets/41d12578-b036-4f7e-9597-a97892d2a98d)

