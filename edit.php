<?php
session_start();
require_once 'config.php';

// Ambil ID dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    $_SESSION['error'] = "ID siswa tidak valid!";
    header("Location: index.php");
    exit();
}

// Inisialisasi variabel
$siswa = null;
$message = '';

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update') {
    $nama = $_POST['nama'] ?? '';
    $email = $_POST['email'] ?? '';
    $no_telepon = $_POST['no_telepon'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $jurusan = $_POST['jurusan'] ?? '';

    // Validasi input
    if (empty($nama) || empty($email) || empty($no_telepon) || empty($alamat) || empty($jurusan)) {
        $message = showError("Semua field harus diisi!");
    } else {
        // Gunakan prepared statement untuk update
        $stmt = $conn->prepare("UPDATE siswa SET nama = ?, email = ?, no_telepon = ?, alamat = ?, jurusan = ? WHERE id = ?");

        if ($stmt === false) {
            $message = showError("Prepare failed: " . htmlspecialchars($conn->error));
        } else {
            // Bind parameters
            $stmt->bind_param("sssssi", $nama, $email, $no_telepon, $alamat, $jurusan, $id);

            // Execute statement
            if ($stmt->execute()) {
                $_SESSION['success'] = "Data siswa berhasil diperbarui!";
                header("Location: index.php");
                exit();
            } else {
                $message = showError("Error: " . htmlspecialchars($stmt->error));
            }

            $stmt->close();
        }
    }
}

// Ambil data siswa berdasarkan ID menggunakan prepared statement
$stmt = $conn->prepare("SELECT id, nama, email, no_telepon, alamat, jurusan FROM siswa WHERE id = ?");

if ($stmt === false) {
    $message = showError("Prepare failed: " . htmlspecialchars($conn->error));
} else {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Data siswa tidak ditemukan!";
        header("Location: index.php");
        exit();
    }

    $siswa = $result->fetch_assoc();
    $stmt->close();
}

$message = displayMessage() . $message;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Siswa - CRUD MySQLi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>📚 Aplikasi CRUD Siswa</h1>
            <p class="subtitle">Edit Data Siswa</p>
        </header>

        <!-- Menampilkan pesan error atau sukses -->
        <?php if (!empty($message)) echo $message; ?>

        <div class="content-wrapper">
            <!-- Form Edit Data Siswa -->
            <section class="form-section edit-form">
                <h2>✏️ Edit Data Siswa</h2>

                <?php if ($siswa): ?>
                    <form method="POST" action="edit.php?id=<?php echo htmlspecialchars($id); ?>" class="form-group">
                        <input type="hidden" name="action" value="update">

                        <div class="form-field">
                            <label for="nama">Nama Lengkap:</label>
                            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($siswa['nama']); ?>" required>
                        </div>

                        <div class="form-field">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($siswa['email']); ?>" required>
                        </div>

                        <div class="form-field">
                            <label for="no_telepon">No. Telepon:</label>
                            <input type="text" id="no_telepon" name="no_telepon" value="<?php echo htmlspecialchars($siswa['no_telepon']); ?>" required>
                        </div>

                        <div class="form-field">
                            <label for="alamat">Alamat:</label>
                            <textarea id="alamat" name="alamat" rows="3" required><?php echo htmlspecialchars($siswa['alamat']); ?></textarea>
                        </div>

                        <div class="form-field">
                            <label for="jurusan">Jurusan:</label>
                            <select id="jurusan" name="jurusan" required>
                                <option value="">-- Pilih Jurusan --</option>
                                <option value="Teknik Informatika" <?php echo ($siswa['jurusan'] == 'Teknik Informatika') ? 'selected' : ''; ?>>Teknik Informatika</option>
                                <option value="Sistem Informasi" <?php echo ($siswa['jurusan'] == 'Sistem Informasi') ? 'selected' : ''; ?>>Sistem Informasi</option>
                                <option value="Manajemen Informatika" <?php echo ($siswa['jurusan'] == 'Manajemen Informatika') ? 'selected' : ''; ?>>Manajemen Informatika</option>
                                <option value="Teknik Komputer" <?php echo ($siswa['jurusan'] == 'Teknik Komputer') ? 'selected' : ''; ?>>Teknik Komputer</option>
                            </select>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-add">💾 Simpan Perubahan</button>
                            <a href="index.php" class="btn btn-cancel">❌ Batal</a>
                        </div>
                    </form>
                <?php endif; ?>
            </section>
        </div>

        <footer>
            <p>&copy; 2024 Aplikasi CRUD Siswa | Tugas Pemrograman Web II</p>
        </footer>
    </div>
</body>
</html>
