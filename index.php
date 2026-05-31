<?php
session_start();
require_once 'config.php';

// Proses tambah data
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    // Ambil data dari form
    $nama = $_POST['nama'] ?? '';
    $email = $_POST['email'] ?? '';
    $no_telepon = $_POST['no_telepon'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $jurusan = $_POST['jurusan'] ?? '';

    // Validasi input
    if (empty($nama) || empty($email) || empty($no_telepon) || empty($alamat) || empty($jurusan)) {
        $_SESSION['error'] = "Semua field harus diisi!";
    } else {
        // Gunakan prepared statement untuk keamanan
        $stmt = $conn->prepare("INSERT INTO siswa (nama, email, no_telepon, alamat, jurusan) VALUES (?, ?, ?, ?, ?)");

        if ($stmt === false) {
            $_SESSION['error'] = "Prepare failed: " . htmlspecialchars($conn->error);
        } else {
            // Bind parameters
            $stmt->bind_param("sssss", $nama, $email, $no_telepon, $alamat, $jurusan);

            // Execute statement
            if ($stmt->execute()) {
                $_SESSION['success'] = "Data siswa berhasil ditambahkan!";
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['error'] = "Error: " . htmlspecialchars($stmt->error);
            }

            $stmt->close();
        }
    }
}

// Ambil semua data siswa untuk ditampilkan
$query = "SELECT id, nama, email, no_telepon, alamat, jurusan FROM siswa ORDER BY id DESC";
$result = $conn->query($query);

if (!$result) {
    $message = showError("Query failed: " . $conn->error);
    $siswa_data = [];
} else {
    $siswa_data = $result->fetch_all(MYSQLI_ASSOC);
}

$message = displayMessage();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi CRUD Siswa - MySQLi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>📚 Aplikasi CRUD Siswa SMK 1 Siber</h1>
            <p class="subtitle">Data Siswa dengan MySQLi Object-Oriented</p>
        </header>

        <!-- Menampilkan pesan error atau sukses -->
        <?php if (!empty($message)) echo $message; ?>

        <div class="content-wrapper">
            <!-- Form Tambah Data Siswa -->
            <section class="form-section">
                <h2>➕ Tambah Data Siswa</h2>
                <form method="POST" action="index.php" class="form-group">
                    <input type="hidden" name="action" value="add">

                    <div class="form-field">
                        <label for="nama">Nama Lengkap:</label>
                        <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
                    </div>

                    <div class="form-field">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Masukkan email" required>
                    </div>

                    <div class="form-field">
                        <label for="no_telepon">No. Telepon:</label>
                        <input type="text" id="no_telepon" name="no_telepon" placeholder="Masukkan nomor telepon" required>
                    </div>

                    <div class="form-field">
                        <label for="alamat">Alamat:</label>
                        <textarea id="alamat" name="alamat" placeholder="Masukkan alamat lengkap" rows="3" required></textarea>
                    </div>

                    <div class="form-field">
                        <label for="jurusan">Jurusan:</label>
                        <select id="jurusan" name="jurusan" required>
                            <option value="">-- Pilih Jurusan --</option>
                            <option value="Teknik Informatika">Teknik Informatika</option>
                            <option value="Sistem Informasi">Sistem Informasi</option>
                            <option value="Manajemen Informatika">Manajemen Informatika</option>
                            <option value="Teknik Komputer">Teknik Komputer</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-add">💾 Tambah Data</button>
                </form>
            </section>

            <!-- Tabel Data Siswa -->
            <section class="table-section">
                <h2>📋 Daftar Siswa</h2>

                <?php if (empty($siswa_data)): ?>
                    <div class="alert alert-info">
                        <p>Tidak ada data siswa. Silakan tambahkan data baru.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No. Telepon</th>
                                    <th>Alamat</th>
                                    <th>Jurusan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($siswa_data as $siswa): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($siswa['id']); ?></td>
                                        <td><?php echo htmlspecialchars($siswa['nama']); ?></td>
                                        <td><?php echo htmlspecialchars($siswa['email']); ?></td>
                                        <td><?php echo htmlspecialchars($siswa['no_telepon']); ?></td>
                                        <td><?php echo htmlspecialchars($siswa['alamat']); ?></td>
                                        <td><?php echo htmlspecialchars($siswa['jurusan']); ?></td>
                                        <td class="action-buttons">
                                            <a href="edit.php?id=<?php echo urlencode($siswa['id']); ?>" class="btn btn-edit">✏️ Edit</a>
                                            <a href="delete.php?id=<?php echo urlencode($siswa['id']); ?>" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus data ini?')">🗑️ Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <p class="data-count">Total: <strong><?php echo count($siswa_data); ?></strong> siswa</p>
                <?php endif; ?>
            </section>
        </div>

        <footer>
            <p>&copy; Aplikasi CRUD Siswa | Tugas Pemrograman Web II | AnggaAnggieanie |250401020172 |</p>
        </footer>
    </div>
</body>
</html>
