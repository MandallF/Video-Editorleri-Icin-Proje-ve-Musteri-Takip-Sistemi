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

    if (empty($username) || empty($password)) {
        $message = 'Lütfen kullanıcı adı ve şifreyi girin.';
    } else {
        $stmt = $pdo->prepare('SELECT id, password FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            header('Location: customers.php');
            exit;
        } else {
            $message = 'Kullanıcı adı veya şifre yanlış.';
        }
    }
}
?>

<h2>Giriş Yap</h2>
<?php if ($message): ?>
    <div class="alert alert-danger"><?=htmlspecialchars($message)?></div>
<?php endif; ?>

<form method="post" action="login.php" class="w-50">
  <div class="mb-3">
    <label for="username" class="form-label">Kullanıcı Adı</label>
    <input type="text" name="username" id="username" class="form-control" required />
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Şifre</label>
    <input type="password" name="password" id="password" class="form-control" required />
  </div>
  <button type="submit" class="btn btn-primary">Giriş Yap</button>
</form>

<?php
require 'footer.php';
?>
