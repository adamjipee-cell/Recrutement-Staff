<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/auth.php';
requireRecruteur();

$pageTitle = 'Quiz de formation';

// ---- Affichage du résultat si on revient d'une soumission ----
$resultat = null;
if (isset($_GET['result'])) {
    $stmt = $pdo->prepare('SELECT * FROM quiz_resultats WHERE id = :id');
    $stmt->execute([':id' => (int)$_GET['result']]);
    $resultat = $stmt->fetch();
}

$questions = $pdo->query('SELECT * FROM quiz_questions ORDER BY ordre ASC')->fetchAll();

require_once __DIR__ . '/../includes/header.php';
?>

<h1 class="page-title">Quiz de formation</h1>
<p class="page-subtitle">12 questions à choix multiples sur les attitudes et responsabilités du staff.</p>

<?php if ($resultat): ?>
    <div class="card">
        <div class="score-circle">
            <div class="num"><?= (int)$resultat['score'] ?>/<?= (int)$resultat['total'] ?></div>
            <div class="den">Score obtenu</div>
        </div>
        <?php
            $pct = round(($resultat['score'] / max($resultat['total'],1)) * 100);
            $niveau = $pct >= 80 ? ['Excellent', 'badge-success'] : ($pct >= 50 ? ['Moyen', 'badge-warning'] : ['Insuffisant', 'badge-danger']);
        ?>
        <p style="text-align:center; margin-top:10px;">
            Résultat : <span class="badge <?= $niveau[1] ?>"><?= $niveau[0] ?> (<?= $pct ?>%)</span>
        </p>
        <div style="text-align:center; margin-top:20px;">
            <a href="/recruteur/quiz.php" class="btn btn-secondary">Repasser le quiz</a>
            <a href="/consultation.php" class="btn btn-primary">Voir tous les résultats</a>
        </div>
    </div>

<?php else: ?>

    <div class="quiz-progress">
        <div class="quiz-progress-bar" id="quizProgressBar"></div>
    </div>

    <div class="card">
        <form method="post" action="/actions/submit_quiz.php">
            <?php foreach ($questions as $i => $q): ?>
                <div class="quiz-question">
                    <h4><?= ($i + 1) ?>. <?= e($q['question']) ?></h4>
                    <div class="quiz-options">
                        <?php foreach (['a','b','c','d'] as $opt): ?>
                            <label>
                                <input type="radio" name="q_<?= (int)$q['id'] ?>" value="<?= $opt ?>" required>
                                <?= e($q["option_$opt"]) ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <button type="submit" class="btn btn-primary btn-block">Valider mes réponses</button>
        </form>
    </div>

<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
