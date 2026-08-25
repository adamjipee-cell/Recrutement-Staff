<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();

$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $pdo->prepare('DELETE FROM quiz_resultats WHERE id = :id');
    $stmt->execute([':id' => $id]);
}

header('Location: /consultation.php?onglet=quiz');
exit;
