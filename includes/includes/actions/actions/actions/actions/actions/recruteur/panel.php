<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/auth.php';
requireRecruteur();

$pageTitle = 'Panel Recruteur';
require_once __DIR__ . '/../includes/header.php';

$nom = $_SESSION['recruteur_nom'] ?? 'Recruteur';

$nbRapports = $pdo->query('SELECT COUNT(*) AS nb FROM rapports')->fetch()['nb'];
$nbQuiz = $pdo->query('SELECT COUNT(*) AS nb FROM quiz_resultats')->fetch()['nb'];
?>

<h1 class="page-title">Bienvenue, <?= e($nom) ?> 👋</h1>
<p class="page-subtitle">Gérez vos entretiens et votre formation depuis ce panel.</p>

<div class="choice-grid">
    <a href="/recruteur/rapport.php" class="choice-card">
        <div class="icon">📝</div>
        <h3>Nouveau rapport d'entretien</h3>
        <p>Soumettre le compte-rendu d'un entretien de candidat.</p>
    </a>

    <a href="/recruteur/quiz.php" class="choice-card">
        <div class="icon">🎓</div>
        <h3>Quiz de formation</h3>
        <p>Testez vos connaissances sur les règles et attitudes du staff (12 questions).</p>
    </a>
</div>

<div class="card mt-20">
    <div class="flex-between">
        <div>
            <strong><?= (int)$nbRapports ?></strong> rapport(s) soumis au total &nbsp;•&nbsp;
            <strong><?= (int)$nbQuiz ?></strong> quiz passé(s) au total
        </div>
        <a href="/consultation.php" class="btn btn-secondary btn-sm">Voir la consultation complète →</a>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
