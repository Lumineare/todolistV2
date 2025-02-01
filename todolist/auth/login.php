<?php
require_once '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];

    $stmt = $koneksi->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        redirect('../index.php');
    } else {
        $error = "Username atau password salah!";
    }
}

require_once '../includes/header.php';
?>

<div class="card shadow mx-auto" style="max-width: 400px;">
    <div class="card-body">
        <h2 class="text-center mb-4">Login</h2>
        
        <?php if(isset($_GET['registrasi'])): ?>
            <div class="alert alert-success">Registrasi berhasil! Silakan login</div>
        <?php endif; ?>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        
        <div class="text-center mt-3">
            Belum punya akun? <a href="register.php">Daftar disini</a>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>