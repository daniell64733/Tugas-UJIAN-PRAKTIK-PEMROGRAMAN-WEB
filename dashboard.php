<?php include 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM pendaftar WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Cek pembayaran terbaru
$stmt_pay = $conn->prepare("SELECT * FROM pembayaran WHERE id_pendaftar = ? ORDER BY id DESC LIMIT 1");
$stmt_pay->bind_param("i", $user_id);
$stmt_pay->execute();
$pay = $stmt_pay->get_result()->fetch_assoc();
$stmt_pay->close();
$status = $pay ? $pay['status'] : null;
$display_status = match ($status) {
    'pending' => 'Menunggu Verifikasi',
    'approved' => 'Lunas',
    'rejected' => 'Ditolak / Upload ulang',
    default => 'Belum Dibayar'
};
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Dashboard Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Dashboard Siswa</h2>
        <p><strong>Nama:</strong> <?php echo $user['nama']; ?></p>
        <p><strong>NISN:</strong> <?php echo $user['nisn']; ?></p>
        <p><strong>Jenis Kelamin:</strong> <?php echo $user['jenis_kelamin']; ?></p>
        <p><strong>Asal Sekolah:</strong> <?php echo $user['asal_sekolah']; ?></p>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        <p><strong>No HP:</strong> <?php echo $user['no_hp']; ?></p>
        <p><strong>Alamat:</strong> <?php echo $user['alamat']; ?></p>
        <p><strong>Status Pembayaran:</strong> <?php echo $display_status; ?></p>

        <?php if (!$pay || $status == 'rejected') { ?>
            <h4>Upload Bukti Pembayaran</h4>
            <form action="upload_bukti.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label>Jumlah Pembayaran</label>
                    <input type="number" name="jumlah" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Bukti (JPG/PNG/PDF, max 2MB)</label>
                    <input type="file" name="bukti" class="form-control" accept=".jpg,.png,.pdf" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        <?php } ?>
        <a href="logout.php" class="btn btn-secondary mt-3">Logout</a>
    </div>
</body>

</html>