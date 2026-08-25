<?php
require_once __DIR__ . '/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $nom = trim($_POST['nom'] ?? '');

    $stmt = $pdo->query('SELECT recruteur_password_hash FROM settings ORDER BY id DESC LIMIT 1');
    $settings = $stmt->fetch();

    if ($settings && password_verify($password, $settings['recruteur_password_hash'])) {
        $_SESSION['role'] = 'recruteur';
        $_SESSION['recruteur_nom'] = $nom !== '' ? $nom : 'Recruteur';
        header('Location: /recruteur/panel.php');
        exit;
    } else {
        $error = 'Mot de passe incorrect.';
    }
}

$pageTitle = 'Connexion Recruteur';
require_once __DIR__ . '/includes/header.php';
?>

<div class="login-wrapper">
    <div class="card">
        <div class="icon-top">🧑‍💼</div>
        <h2>Espace Recruteur</h2>
        <p class="subtitle">Entrez le mot de passe recruteur pour accéder au panel</p>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="nom">Votre pseudo (optionnel)</label>
                <input type="text" id="nom" name="nom" placeholder="Ex: Jean_Recruteur">
            </div>
            <div class="form-group">
                <label for="password">Mot de passe recruteur</label>
                <input type="password" id="password" name="password" required autofocus>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
