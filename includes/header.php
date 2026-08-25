<?php
// $pageTitle peut être défini avant l'inclusion de ce fichier
if (!isset($pageTitle)) { $pageTitle = 'Recrutement Staff Discord'; }
$role = $_SESSION['role'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($pageTitle) ?> — Recrutement Staff</title>
<link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<header class="navbar">
    <div class="navbar-inner">
        <a href="/index.php" class="logo">⚡ Staff Recrutement</a>
        <nav>
            <?php if ($role === 'recruteur' || $role === 'admin'): ?>
                <a href="/recruteur/panel.php">Panel Recruteur</a>
                <a href="/recruteur/rapport.php">Nouveau rapport</a>
                <a href="/recruteur/quiz.php">Quiz formation</a>
                <a href="/consultation.php">Consultation</a>
            <?php endif; ?>

            <?php if ($role === 'admin'): ?>
                <a href="/admin/panel.php">Panel Admin</a>
                <a href="/admin/stats.php">Statistiques</a>
                <a href="/admin/parametres.php">Paramètres</a>
            <?php endif; ?>

            <?php if ($role): ?>
                <span class="badge-role"><?= $role === 'admin' ? 'Admin' : 'Recruteur' ?></span>
                <a href="/logout.php">Déconnexion</a>
            <?php else: ?>
                <a href="/login_recruteur.php">Recruteur</a>
                <a href="/login_admin.php">Admin</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="container">
