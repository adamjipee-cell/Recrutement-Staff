<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();

$pageTitle = 'Statistiques';

$total = (int)$pdo->query('SELECT COUNT(*) AS nb FROM rapports')->fetch()['nb'];

$parAvis = $pdo->query(
    "SELECT avis_final, COUNT(*) AS nb FROM rapports GROUP BY avis_final"
)->fetchAll();

$noteMoyenne = $pdo->query('SELECT AVG(note) AS moy FROM rapports')->fetch()['moy'];

$quizStats = $pdo->query(
    'SELECT COUNT(*) AS nb, AVG(score/total)*100 AS moy, MAX(score/total)*100 AS max_pct, MIN(score/total)*100 AS min_pct FROM quiz_resultats'
)->fetch();

require_once __DIR__ . '/../includes/header.php';
?>

<h1 class="page-title">Statistiques détaillées</h1>
<p class="page-subtitle">Analyse des rapports d'entretien et des performances au quiz.</p>

<div class="card">
    <h3 style="margin-bottom:16px;">Rapports d'entretien</h3>
    <p class="text-muted">Total de rapports : <strong style="color:var(--text-primary)"><?= $total ?></strong></p>
    <p class="text-muted">Note moyenne accordée : <strong style="color:var(--text-primary)"><?= $noteMoyenne !== null ? round($noteMoyenne, 1) . '/10' : '—' ?></strong></p>

    <div class="mt-20">
        <?php foreach ($parAvis as $a): ?>
            <?php
                $pct = $total > 0 ? round(($a['nb'] / $total) * 100) : 0;
                $badgeClass = $a['avis_final'] === 'Favorable' ? 'badge-success'
                    : ($a['avis_final'] === 'Défavorable' ? 'badge-danger' : 'badge-warning');
            ?>
            <div class="flex-between" style="margin-bottom:8px;">
                <span class="badge <?= $badgeClass ?>"><?= e($a['avis_final']) ?></span>
                <span class="text-muted"><?= (int)$a['nb'] ?> rapport(s) — <?= $pct ?>%</span>
            </div>
        <?php endforeach; ?>
        <?php if (empty($parAvis)): ?>
            <p class="text-muted">Aucune donnée disponible.</p>
        <?php endif; ?>
    </div>
</div>

<div class="card mt-20">
    <h3 style="margin-bottom:16px;">Quiz de formation</h3>
    <div class="stats-grid" style="margin-bottom:0;">
        <div class="stat-card">
            <div class="value"><?= (int)($quizStats['nb'] ?? 0) ?></div>
            <div class="label">Quiz passés</div>
        </div>
        <div class="stat-card">
            <div class="value"><?= $quizStats['moy'] !== null ? round($quizStats['moy']) . '%' : '—' ?></div>
            <div class="label">Score moyen</div>
        </div>
        <div class="stat-card">
            <div class="value"><?= $quizStats['max_pct'] !== null ? round($quizStats['max_pct']) . '%' : '—' ?></div>
            <div class="label">Meilleur score</div>
        </div>
        <div class="stat-card">
            <div class="value"><?= $quizStats['min_pct'] !== null ? round($quizStats['min_pct']) . '%' : '—' ?></div>
            <div class="label">Score le plus bas</div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
