<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Form Pendaftaran PPDB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Form Pendaftaran PPDB</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>NISN</label>
                <input type="text" name="nisn" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select" required>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Asal Sekolah</label>
                <input type="text" name="asal_sekolah" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>No HP</label>
                <input type="text" name="no_hp" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Daftar</button>
        </form>
    </div>
</body>

</html>

<?php
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $nisn = $_POST['nisn'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $asal_sekolah = $_POST['asal_sekolah'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];
    $password = hashPassword($_POST['password']);

    // Prepared statement untuk keamanan
    $stmt = $conn->prepare("INSERT INTO pendaftar (nama, nisn, jenis_kelamin, asal_sekolah, email, no_hp, alamat, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $nama, $nisn, $jenis_kelamin, $asal_sekolah, $email, $no_hp, $alamat, $password);
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Pendaftaran berhasil! Silakan login.</div>";
        header("Location: login.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }
    $stmt->close();
}
?>