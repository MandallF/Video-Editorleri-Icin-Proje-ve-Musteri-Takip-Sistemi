<?php
require 'db.php';
require 'header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$action = $_GET['action'] ?? '';
$edit_id = isset($_GET['edit']) ? intval($_GET['edit']) : 0;

$message = '';

// Form gönderilmişse (ekleme / güncelleme)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $notes = trim($_POST['notes']);
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($name === '') {
        $message = 'Müşteri adı boş olamaz.';
    } else {
        if ($id > 0) {
            // Güncelle
            $stmt = $pdo->prepare("UPDATE customers SET name = ?, email = ?, phone = ?, notes = ? WHERE id = ? AND user_id = ?");
            $stmt->execute([$name, $email, $phone, $notes, $id, $user_id]);
            $message = 'Müşteri güncellendi.';
        } else {
            // Ekle
            $stmt = $pdo->prepare("INSERT INTO customers (user_id, name, email, phone, notes) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $name, $email, $phone, $notes]);
            $message = 'Yeni müşteri eklendi.';
        }
    }
}

// Müşteri listesi çek
$stmt = $pdo->prepare("SELECT * FROM customers WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$customers = $stmt->fetchAll();

// Eğer düzenleme için id varsa veriyi al
$edit_customer = null;
if ($edit_id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ? AND user_id = ?");
    $stmt->execute([$edit_id, $user_id]);
    $edit_customer = $stmt->fetch();
}
?>

<h2>Müşteri Yönetimi</h2>

<?php if ($message): ?>
    <div class="alert alert-info"><?=htmlspecialchars($message)?></div>
<?php endif; ?>

<!-- Müşteri Ekle/Güncelle Formu -->
<div class="card mb-4" style="max-width: 600px;">
  <div class="card-body">
    <h5 class="card-title"><?= $edit_customer ? 'Müşteri Güncelle' : 'Yeni Müşteri Ekle' ?></h5>
    <form method="post" action="customers.php">
      <input type="hidden" name="id" value="<?= $edit_customer ? $edit_customer['id'] : 0 ?>">
      <div class="mb-3">
        <label for="name" class="form-label">Müşteri Adı *</label>
        <input type="text" class="form-control" id="name" name="name" required value="<?= $edit_customer ? htmlspecialchars($edit_customer['name']) : '' ?>">
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">E-posta</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= $edit_customer ? htmlspecialchars($edit_customer['email']) : '' ?>">
      </div>
      <div class="mb-3">
        <label for="phone" class="form-label">Telefon</label>
        <input type="text" class="form-control" id="phone" name="phone" value="<?= $edit_customer ? htmlspecialchars($edit_customer['phone']) : '' ?>">
      </div>
      <div class="mb-3">
        <label for="notes" class="form-label">Notlar</label>
        <textarea class="form-control" id="notes" name="notes"><?= $edit_customer ? htmlspecialchars($edit_customer['notes']) : '' ?></textarea>
      </div>
      <button type="submit" class="btn btn-success"><?= $edit_customer ? 'Güncelle' : 'Ekle' ?></button>
      <?php if ($edit_customer): ?>
          <a href="customers.php" class="btn btn-secondary ms-2">İptal</a>
      <?php endif; ?>
    </form>
  </div>
</div>

<!-- Müşteri Listesi -->
<table class="table table-striped table-bordered" style="max-width: 900px;">
  <thead>
    <tr>
      <th>ID</th>
      <th>Ad</th>
      <th>E-posta</th>
      <th>Telefon</th>
      <th>Notlar</th>
      <th>İşlemler</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($customers as $c): ?>
      <tr>
        <td><?= $c['id'] ?></td>
        <td><?= htmlspecialchars($c['name']) ?></td>
        <td><?= htmlspecialchars($c['email']) ?></td>
        <td><?= htmlspecialchars($c['phone']) ?></td>
        <td><?= htmlspecialchars($c['notes']) ?></td>
        <td>
          <a href="customers.php?edit=<?= $c['id'] ?>" class="btn btn-sm btn-primary">Düzenle</a>
          <a href="delete_customer.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Müşteriyi silmek istediğinize emin misiniz?');">Sil</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php
require 'footer.php';
?>
