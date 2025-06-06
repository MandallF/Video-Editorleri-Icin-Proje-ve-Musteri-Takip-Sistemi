<?php
require 'db.php';
require 'header.php';

if (isset($_SESSION['user_id'])) {
    header('Location: customers.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if (empty($username) || empty($password) || empty($password_confirm)) {
        $message = 'Lütfen tüm alanları doldurun.';
    } elseif ($password !== $password_confirm) {
        $message = 'Şifreler eşleşmiyor.';
    } else {
        // Kullanıcı var mı kontrol
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $message = 'Bu kullanıcı adı zaten kayıtlı.';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
            $stmt->execute([$username, $hashed_password]);
            $message = 'Kayıt başarılı! Giriş yapabilirsiniz.';
        }
    }
}
?>

<h2>Kayıt Ol</h2>
<?php if ($message): ?>
    <div class="alert alert-info"><?=htmlspecialchars($message)?></div>
<?php endif; ?>

<form method="post" action="register.php" class="w-50">
  <div class="mb-3">
    <label for="username" class="form-label">Kullanıcı Adı</label>
    <input type="text" name="username" id="username" class="form-control" required />
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Şifre</label>
    <input type="password" name="password" id="password" class="form-control" required />
  </div>
  <div class="mb-3">
    <label for="password_confirm" class="form-label">Şifre (Tekrar)</label>
    <input type="password" name="password_confirm" id="password_confirm" class="form-control" required />
  </div>
  <button type="submit" class="btn btn-primary">Kayıt Ol</button>
</form>

<?php
require 'footer.php';
?>
