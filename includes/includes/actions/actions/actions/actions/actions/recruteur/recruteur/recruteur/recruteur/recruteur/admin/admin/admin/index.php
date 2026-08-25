<?php
require_once __DIR__ . '/config.php';
$pageTitle = 'Accueil';
require_once __DIR__ . '/includes/header.php';
?>

<div class="hero">
    <h1>Plateforme de <span>Recrutement Staff</span></h1>
    <p>Gérez les entretiens, les rapports et la formation de votre future équipe Discord.</p>
</div>

<div class="choice-grid">
    <a href="/login_recruteur.php" class="choice-card">
        <div class="icon">🧑‍💼</div>
        <h3>Je suis Recruteur</h3>
        <p>Soumettre un rapport d'entretien, passer le quiz de formation et consulter les résultats.</p>
    </a>

    <a href="/login_admin.php" class="choice-card">
        <div class="icon">🛡️</div>
        <h3>Je suis Admin</h3>
        <p>Superviser l'ensemble des rapports, les statistiques et gérer les accès de la plateforme.</p>
    </a>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
