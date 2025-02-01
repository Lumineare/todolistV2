<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if user exists
    $stmt = $koneksi->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "Username atau email sudah terdaftar!";
    } else {
        // Insert new user
        $stmt = $koneksi->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        
        if ($stmt->execute()) {
            redirect('login.php?registrasi=berhasil');
        } else {
            $error = "Registrasi gagal: " . $stmt->error;
        }
    }
}

require_once '../includes/header.php';
?>

<div class="card shadow mx-auto" style="max-width: 400px;">
    <div class="card-body">
        <h2 class="text-center mb-4">Daftar Akun</h2>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required minlength="6">
            </div>
            
            <button type="submit" class="btn btn-primary w-100">Daftar</button>
        </form>
        
        <div class="text-center mt-3">
            Sudah punya akun? <a href="login.php">Login disini</a>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
