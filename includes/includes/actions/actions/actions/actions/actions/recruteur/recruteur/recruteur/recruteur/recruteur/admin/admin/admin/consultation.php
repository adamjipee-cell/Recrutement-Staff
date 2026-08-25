<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/auth.php';
requireRecruteur(); // recruteur OU admin

$pageTitle = 'Consultation';
$onglet = $_GET['onglet'] ?? 'rapports';

$rapports = $pdo->query('SELECT * FROM rapports ORDER BY created_at DESC')->fetchAll();
$quizResultats = $pdo->query('SELECT * FROM quiz_resultats ORDER BY created_at DESC')->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<h1 class="page-title">Consultation</h1>
<p class="page-subtitle">Retrouvez ici l'ensemble des rapports d'entretien et des résultats de quiz.</p>

<div class="flex-between">
    <div>
        <a href="?onglet=rapports" class="btn <?= $onglet === 'rapports' ? 'btn-primary' : 'btn-secondary' ?> btn-sm">
            📄 Rapports (<?= count($rapports) ?>)
        </a>
        <a href="?onglet=quiz" class="btn <?= $onglet === 'quiz' ? 'btn-primary' : 'btn-secondary' ?> btn-sm">
            🎓 Résultats quiz (<?= count($quizResultats) ?>)
        </a>
    </div>
</div>

<?php if ($onglet === 'rapports'): ?>

    <?php if (empty($rapports)): ?>
        <div class="card"><p class="text-muted">Aucun rapport soumis pour le moment.</p></div>
    <?php endif; ?>

    <?php foreach ($rapports as $r): ?>
        <div class="card">
            <div class="flex-between">
                <div>
                    <strong><?= e($r['pseudo_discord']) ?></strong>
                    <span class="text-muted">(ID : <?= e($r['id_discord']) ?>)</span>
                </div>
                <div>
                    <?php
                        $badgeClass = $r['avis_final'] === 'Favorable' ? 'badge-success'
                            : ($r['avis_final'] === 'Défavorable' ? 'badge-danger' : 'badge-warning');
                    ?>
                    <span class="badge <?= $badgeClass ?>"><?= e($r['avis_final']) ?></span>
                    <span class="badge badge-warning" style="background:rgba(139,92,246,0.15); color:#8b5cf6;">
                        Note : <?= (int)$r['note'] ?>/10
                    </span>
                </div>
            </div>

            <p class="text-muted" style="margin-top:8px; font-size:0.85rem;">
                Recruteur : <?= e($r['recruteur_nom']) ?> • Durée : <?= e($r['duree_entretien']) ?> •
                Le <?= date('d/m/Y à H:i', strtotime($r['created_at'])) ?>
            </p>

            <div class="detail-box"><strong>Présentation :</strong><br><?= nl2br(e($r['presentation'])) ?></div>
            <div class="detail-box"><strong>Définition d'un bon staff :</strong><br><?= nl2br(e($r['definition_bon_staff'])) ?></div>
            <div class="detail-box"><strong>Pourquoi lui :</strong><br><?= nl2br(e($r['pourquoi_lui'])) ?></div>
            <?php if (!empty($r['commentaire'])): ?>
                <div class="detail-box"><strong>Commentaire :</strong><br><?= nl2br(e($r['commentaire'])) ?></div>
            <?php endif; ?>

            <?php if (isAdmin()): ?>
                <div class="mt-20">
                    <a href="/actions/delete_rapport.php?id=<?= (int)$r['id'] ?>" class="btn btn-danger btn-sm confirm-delete">🗑 Supprimer</a>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

<?php else: ?>

    <?php if (empty($quizResultats)): ?>
        <div class="card"><p class="text-muted">Aucun quiz passé pour le moment.</p></div>
    <?php endif; ?>

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Recruteur</th>
                        <th>Score</th>
                        <th>Pourcentage</th>
                        <th>Date</th>
                        <?php if (isAdmin()): ?><th>Action</th><?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($quizResultats as $q): ?>
                        <?php $pct = round(($q['score'] / max($q['total'],1)) * 100); ?>
                        <tr>
                            <td><?= e($q['recruteur_nom']) ?></td>
                            <td><?= (int)$q['score'] ?>/<?= (int)$q['total'] ?></td>
                            <td>
                                <span class="badge <?= $pct >= 80 ? 'badge-success' : ($pct >= 50 ? 'badge-warning' : 'badge-danger') ?>">
                                    <?= $pct ?>%
                                </span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($q['created_at'])) ?></td>
                            <?php if (isAdmin()): ?>
                                <td><a href="/actions/delete_quiz.php?id=<?= (int)$q['id'] ?>" class="btn btn-danger btn-sm confirm-delete">Supprimer</a></td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
