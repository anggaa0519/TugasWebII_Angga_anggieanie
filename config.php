<?php
/**
 * Database Configuration File
 * Menggunakan MySQLi Object-Oriented Style
 */

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_crud";

// Create connection menggunakan OOP style
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Set charset untuk UTF-8
$conn->set_charset("utf8mb4");

// Fungsi helper untuk menampilkan pesan error
function showError($message) {
    return "<div class='alert alert-danger' role='alert'>
                <strong>Error:</strong> " . htmlspecialchars($message) . "
            </div>";
}

// Fungsi helper untuk menampilkan pesan sukses
function showSuccess($message) {
    return "<div class='alert alert-success' role='alert'>
                <strong>Sukses:</strong> " . htmlspecialchars($message) . "
            </div>";
}

// Fungsi untuk mengecek dan menampilkan pesan dari session
function displayMessage() {
    $message = '';

    if (isset($_SESSION['success'])) {
        $message = showSuccess($_SESSION['success']);
        unset($_SESSION['success']);
    }

    if (isset($_SESSION['error'])) {
        $message = showError($_SESSION['error']);
        unset($_SESSION['error']);
    }

    return $message;
}
?>
