<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/auth.php';
requireRecruteur();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /recruteur/quiz.php');
    exit;
}

$questions = $pdo->query('SELECT id, bonne_reponse FROM quiz_questions')->fetchAll();

$score = 0;
$total = count($questions);
$details = [];

foreach ($questions as $q) {
    $champ = 'q_' . $q['id'];
    $reponseDonnee = $_POST[$champ] ?? null;
    $correct = ($reponseDonnee === $q['bonne_reponse']);
    if ($correct) {
        $score++;
    }
    $details[] = [
        'question_id' => (int)$q['id'],
        'reponse'     => $reponseDonnee,
        'correct'     => $correct,
    ];
}

$stmt = $pdo->prepare(
    'INSERT INTO quiz_resultats (recruteur_nom, score, total, details) VALUES (:nom, :score, :total, :details)'
);
$stmt->execute([
    ':nom'     => $_SESSION['recruteur_nom'] ?? 'Recruteur',
    ':score'   => $score,
    ':total'   => $total,
    ':details' => json_encode($details, JSON_UNESCAPED_UNICODE),
]);

$resultId = $pdo->lastInsertId();

header('Location: /recruteur/quiz.php?result=' . $resultId);
exit;
