<?php include 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

if (isset($_FILES['bukti'])) {
    $file = $_FILES['bukti'];
    $jumlah = $_POST['jumlah'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'png', 'pdf'];

    if (!in_array($ext, $allowed)) {
        echo "Tipe file tidak diizinkan!";
        exit();
    }
    if ($file['size'] > 2 * 1024 * 1024) {
        echo "File terlalu besar!";
        exit();
    }

    $new_name = time() . '.' . $ext;
    $upload_path = 'uploads/' . $new_name;
    if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        $tanggal = date('Y-m-d H:i:s');
        $stmt = $conn->prepare("INSERT INTO pembayaran (id_pendaftar, tanggal, jumlah, bukti, status) VALUES (?, ?, ?, ?, 'pending')");
        $stmt->bind_param("isis", $user_id, $tanggal, $jumlah, $new_name);
        if ($stmt->execute()) {
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Gagal upload file!";
    }
}
