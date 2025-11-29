<?php include 'config.php';
session_start(); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Login Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Login Siswa</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label>NISN atau Email</label>
                <input type="text" name="identifier" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>

</html>

<?php
if (isset($_POST['submit'])) {
    $identifier = $_POST['identifier'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM pendaftar WHERE nisn = ? OR email = ?");
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (verifyPassword($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Password salah!</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>User tidak ditemukan!</div>";
    }
    $stmt->close();
}
?>