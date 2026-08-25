<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();

$cible = $_POST['cible'] ?? '';
$passwordActuel = $_POST['password_admin_actuel'] ?? '';
$nouveau = $_POST['nouveau_mdp'] ?? '';
$confirmer = $_POST['confirmer_mdp'] ?? '';

if (!in_array($cible, ['recruteur', 'admin'], true) || $passwordActuel === '' || $nouveau === '' || $confirmer === '') {
    header('Location: /admin/parametres.php?error=empty');
    exit;
}

// Vérification du mot de passe admin actuel
$settings = $pdo->query('SELECT * FROM settings ORDER BY id DESC LIMIT 1')->fetch();

if (!$settings || !password_verify($passwordActuel, $settings['admin_password_hash'])) {
    header('Location: /admin/parametres.php?error=mismatch');
    exit;
}

if ($nouveau !== $confirmer) {
    header('Location: /admin/parametres.php?error=confirm');
    exit;
}

$nouveauHash = password_hash($nouveau, PASSWORD_BCRYPT);
$colonne = $cible === 'admin' ? 'admin_password_hash' : 'recruteur_password_hash';

$stmt = $pdo->prepare("UPDATE settings SET $colonne = :hash WHERE id = :id");
$stmt->execute([':hash' => $nouveauHash, ':id' => $settings['id']]);

header('Location: /admin/parametres.php?success=1');
exit;
