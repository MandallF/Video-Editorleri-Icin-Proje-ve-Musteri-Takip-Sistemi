<?php
session_start();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Video Editörleri Müşteri Takip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="customers.php">Müşteri Takip</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <?php if (isset($_SESSION['user_id'])): ?>
          <li class="nav-item"><a class="nav-link" href="customers.php">Müşteriler</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Çıkış</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="login.php">Giriş</a></li>
          <li class="nav-item"><a class="nav-link" href="register.php">Kayıt Ol</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
