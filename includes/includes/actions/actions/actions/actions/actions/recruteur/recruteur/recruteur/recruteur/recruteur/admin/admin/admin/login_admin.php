<?php
require_once __DIR__ . '/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->query('SELECT admin_password_hash FROM settings ORDER BY id DESC LIMIT 1');
    $settings = $stmt->fetch();

    if ($settings && password_verify($password, $settings['admin_password_hash'])) {
        $_SESSION['role'] = 'admin';
        $_SESSION['recruteur_nom'] = $_SESSION['recruteur_nom'] ?? 'Admin';
        header('Location: /admin/panel.php');
        exit;
    } else {
        $error = 'Mot de passe incorrect.';
    }
}

$pageTitle = 'Connexion Admin';
require_once __DIR__ . '/includes/header.php';
?>

<div class="login-wrapper">
    <div class="card">
        <div class="icon-top">🛡️</div>
        <h2>Espace Admin</h2>
        <p class="subtitle">Entrez le mot de passe administrateur pour accéder au panel</p>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="password">Mot de passe admin</label>
                <input type="password" id="password" name="password" required autofocus>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
