<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();

$pageTitle = 'Panel Admin';
require_once __DIR__ . '/../includes/header.php';

$nbRapports = $pdo->query('SELECT COUNT(*) AS nb FROM rapports')->fetch()['nb'];
$nbQuiz = $pdo->query('SELECT COUNT(*) AS nb FROM quiz_resultats')->fetch()['nb'];
?>

<h1 class="page-title">Panel Administrateur</h1>
<p class="page-subtitle">Vue d'ensemble et gestion complète de la plateforme.</p>

<div class="choice-grid">
    <a href="/consultation.php" class="choice-card">
        <div class="icon">📋</div>
        <h3>Consultation</h3>
        <p>Voir tous les rapports d'entretien et les résultats de quiz.</p>
    </a>

    <a href="/admin/stats.php" class="choice-card">
        <div class="icon">📊</div>
        <h3>Statistiques</h3>
        <p>Analyse des performances et des avis.</p>
    </a>

    <a href="/admin/parametres.php" class="choice-card">
        <div class="icon">⚙️</div>
        <h3>Paramètres</h3>
        <p>Changer les mots de passe recruteur et admin.</p>
    </a>
</div>

<div class="card mt-20">
    <div class="flex-between">
        <div>
            <strong><?= (int)$nbRapports ?></strong> rapport(s) • 
            <strong><?= (int)$nbQuiz ?></strong> quiz passé(s)
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
