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

// Gunakan prepared statement untuk delete
$stmt = $conn->prepare("DELETE FROM siswa WHERE id = ?");

if ($stmt === false) {
    $_SESSION['error'] = "Prepare failed: " . htmlspecialchars($conn->error);
} else {
    // Bind parameter
    $stmt->bind_param("i", $id);

    // Execute statement
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $_SESSION['success'] = "Data siswa berhasil dihapus!";
        } else {
            $_SESSION['error'] = "Data siswa tidak ditemukan!";
        }
    } else {
        $_SESSION['error'] = "Error: " . htmlspecialchars($stmt->error);
    }

    $stmt->close();
}

// Redirect kembali ke halaman utama
header("Location: index.php");
exit();
?>
