# 📚 Aplikasi CRUD Siswa - MySQLi Object-Oriented

[![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4?style=flat&logo=php)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat&logo=mysql)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-Educational-brightgreen)](./LICENSE)
[![Status](https://img.shields.io/badge/Status-Active-green)](https://github.com)

Aplikasi web mini untuk demonstrasi operasi CRUD (Create, Read, Update, Delete) menggunakan PHP MySQLi dengan style Object-Oriented. Aplikasi ini menampilkan best practices untuk keamanan database dan user experience.

## 🌟 Fitur Utama

- ✅ **Create** - Menambahkan data siswa baru dengan validasi
- ✅ **Read** - Menampilkan daftar lengkap siswa dalam tabel
- ✅ **Update** - Mengubah data siswa dengan form pre-filled
- ✅ **Delete** - Menghapus data dengan konfirmasi keamanan
- ✅ **Prepared Statements** - Perlindungan dari SQL Injection
- ✅ **Input Validation** - Validasi data sebelum disimpan
- ✅ **Error Handling** - Pesan error yang user-friendly
- ✅ **Responsive Design** - Kompatibel dengan semua device
- ✅ **Session Management** - Pesan temporary dengan session

## 📸 Screenshots

### Halaman Utama - Form Tambah Data
![Form Tambah Data](./screenshots/01-form-tambah.png)
*Formulir untuk menambahkan data siswa baru dengan validasi lengkap*

### Daftar Siswa - Tabel Data
![Daftar Siswa](./screenshots/02-daftar-siswa.png)
*Menampilkan semua data siswa dalam tabel dengan tombol Edit dan Hapus*

### Success Message - Data Berhasil Ditambahkan
![Success Message](./screenshots/03-success-message.png)
*Pesan sukses ketika data berhasil ditambahkan ke database*

### Form Kosong - Input Placeholder
![Form Kosong](./screenshots/04-form-kosong.png)
*Form yang sudah direset dengan placeholder untuk panduan pengguna*

### Daftar Siswa - Setelah Penambahan
![Daftar Update](./screenshots/05-daftar-update.png)
*Data siswa yang sudah ditambahkan muncul di tabel dengan tombol aksi*

### Database View - phpMyAdmin
![Database View](./screenshots/06-database-view.png)
*Tampilan database di phpMyAdmin menunjukkan struktur tabel siswa*

## 🚀 Quick Start

### Prasyarat
- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Web Server (Apache, Nginx, dll)

### Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/anggaa0519/TugasWebII_Angga_anggieanie.git
   cd TugasWebII_Angga_anggieanie
   ```

2. **Setup Database**
   ```bash
   # Menggunakan MySQL command line
   mysql -u root -p < database.sql
   
   # Atau import di phpMyAdmin:
   # 1. Buka http://localhost/phpmyadmin
   # 2. Klik tab "Import"
   # 3. Pilih file database.sql
   # 4. Klik "Go"
   ```

3. **Konfigurasi Database**
   ```php
   // Edit file config.php
   $servername = "localhost";
   $username = "root";
   $password = ""; // Sesuaikan dengan password Anda
   $database = "db_crud";
   ```

4. **Copy ke Web Root**
   ```bash
   # XAMPP
   cp -r . C:\xampp\htdocs\crud-siswa\
   
   # WAMP
   cp -r . C:\wamp\www\crud-siswa\
   
   # Linux
   sudo cp -r . /var/www/html/crud-siswa/
   ```

5. **Jalankan Aplikasi**
   ```
   http://localhost/TugasWebII_Angga_anggieanie/
   ```

## 📋 Cara Penggunaan

### Menambah Data
1. Scroll ke bagian "Tambah Data Siswa"
2. Isi semua field form
3. Klik tombol "Tambah Data"
4. Data akan muncul di tabel

### Melihat Data
- Semua data siswa ditampilkan di tabel "Daftar Siswa"
- Klik tombol Edit atau Hapus untuk action

### Mengubah Data
1. Klik tombol "Edit" pada data yang ingin diubah
2. Ubah field yang diperlukan
3. Klik "Simpan Perubahan"
4. Data terubah akan ditampilkan di tabel

### Menghapus Data
1. Klik tombol "Hapus" pada data yang ingin dihapus
2. Konfirmasi penghapusan
3. Data akan dihapus dari database

## 🔒 Fitur Keamanan

### 1. Prepared Statements
Semua query menggunakan prepared statements untuk melindungi dari SQL Injection:
```php
$stmt = $conn->prepare("INSERT INTO siswa (nama, email) VALUES (?, ?)");
$stmt->bind_param("ss", $nama, $email);
$stmt->execute();
```

### 2. Input Validation
Validasi data sebelum disimpan:
```php
if (empty($nama) || empty($email) || empty($no_telepon)) {
    $_SESSION['error'] = "Semua field harus diisi!";
}
```

### 3. Output Escaping
Menggunakan htmlspecialchars() untuk mencegah XSS:
```php
echo htmlspecialchars($siswa['nama']);
```

### 4. Confirmation Dialog
Meminta konfirmasi sebelum delete:
```javascript
onclick="return confirm('Yakin ingin menghapus data ini?')"
```

### 5. Error Handling
Menampilkan pesan error yang user-friendly:
```php
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}
```

## 📁 Struktur File

```
crud-siswa/
├── index.php                # Halaman utama (list + form CREATE)
├── edit.php                 # Halaman UPDATE
├── delete.php               # Script DELETE
├── config.php               # Koneksi database (OOP MySQLi)
├── style.css                # Styling responsive
├── database.sql             # Setup database & sample data
├── DOKUMENTASI_TUGAS.docx   # Dokumentasi (Word)
├── DOKUMENTASI_TUGAS.md     # Dokumentasi (Markdown)
├── README.md                # File ini
└── screenshots/             # Screenshot untuk dokumentasi
    ├── 01-form-tambah.png
    ├── 02-daftar-siswa.png
    ├── 03-success-message.png
    ├── 04-form-kosong.png
    ├── 05-daftar-update.png
    └── 06-database-view.png
```

## 🛠️ Technology Stack

| Technology | Version | Purpose |
|-----------|---------|---------|
| PHP | 7.4+ | Backend scripting |
| MySQL | 5.7+ | Database management |
| MySQLi | OOP | Database extension |
| HTML5 | - | Markup |
| CSS3 | - | Styling & responsive |
| JavaScript | ES6+ | Client-side functionality |

## 📊 Database Structure

### Table: siswa

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | INT | AUTO_INCREMENT, PRIMARY KEY | Unique identifier |
| nama | VARCHAR(100) | NOT NULL | Student name |
| email | VARCHAR(100) | NOT NULL, UNIQUE | Student email |
| no_telepon | VARCHAR(15) | NOT NULL | Phone number |
| alamat | TEXT | NOT NULL | Address |
| jurusan | VARCHAR(50) | NOT NULL | Major/Program |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Creation date |
| updated_at | TIMESTAMP | ON UPDATE CURRENT_TIMESTAMP | Last update |


## 📖 Dokumentasi MySQLi Style

Aplikasi ini menggunakan **MySQLi Object-Oriented (OOP) Style**:

### Keuntungan OOP
- Struktur kode lebih rapi dan terorganisir
- Modern dan merupakan best practice industri
- Better error handling dengan exception
- Mudah mengimplementasikan prepared statements
- Scalable dan maintainable

### Contoh Implementasi

**Koneksi Database:**
```php
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
```

**Prepared Statement SELECT:**
```php
$stmt = $conn->prepare("SELECT * FROM siswa WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$siswa = $result->fetch_assoc();
```

## 🔍 Testing

### Manual Testing
1. Buka aplikasi di browser
2. Test CREATE: Tambahkan data siswa baru
3. Test READ: Lihat daftar siswa di tabel
4. Test UPDATE: Edit salah satu data
5. Test DELETE: Hapus salah satu data
6. Test Validation: Coba submit form kosong
7. Test Error: Lihat pesan error jika ada

### Test Case Data
```
Nama: Test Siswa
Email: test@example.com
No. Telepon: 081234567890
Alamat: Jl. Test No. 1
Jurusan: Teknik Informatika
```

## 🐛 Troubleshooting

### Error: "Koneksi database gagal"
- ✅ Pastikan MySQL server sudah running
- ✅ Cek kredensial di config.php
- ✅ Pastikan database db_crud sudah dibuat

### Error: "Tabel tidak ditemukan"
- ✅ Jalankan database.sql untuk membuat tabel
- ✅ Cek di phpMyAdmin apakah tabel sudah ada

### Data tidak muncul di tabel
- ✅ Pastikan MySQLi extension enabled
- ✅ Cek file permissions (readable)
- ✅ Lihat error log di browser console (F12)

### Form tidak bisa di-submit
- ✅ Pastikan semua field sudah diisi
- ✅ Cek format email valid
- ✅ Lihat console browser untuk error message

## 📝 Requirements

✅ Menggunakan MySQLi Object-Oriented Style  
✅ Fitur CREATE - Menambah data baru  
✅ Fitur READ - Menampilkan data  
✅ Fitur UPDATE - Mengubah data  
✅ Fitur DELETE - Menghapus data  
✅ Pesan error jika koneksi/query gagal  
✅ Prepared statements untuk keamanan  
✅ Desain tampilan fungsional & responsive  
✅ Dokumentasi lengkap  

## 🎓 Learning Outcomes

Setelah menggunakan aplikasi ini, Anda akan memahami:
- Koneksi database dengan MySQLi OOP
- Operasi CRUD yang lengkap
- Prepared statements untuk keamanan
- Input validation dan error handling
- Session management
- Responsive web design
- Best practices dalam web development

## 📄 Lisensi

Proyek ini dibuat untuk keperluan pendidikan. Gunakan dan modifikasi sesuai kebutuhan Anda.

## 👨‍💼 Author

**Tugas Pemrograman Web II**  
SMK 1 Siber - 2024
ANGGA ANGGIEANIE |
