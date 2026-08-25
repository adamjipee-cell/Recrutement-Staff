<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/auth.php';
requireRecruteur();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /recruteur/rapport.php');
    exit;
}

$note = (int)($_POST['note'] ?? 0);
$note = max(0, min(10, $note));

$avisAutorises = ['Favorable', 'Défavorable', 'À revoir'];
$avis = in_array($_POST['avis_final'] ?? '', $avisAutorises, true) ? $_POST['avis_final'] : 'À revoir';

$stmt = $pdo->prepare(
    'INSERT INTO rapports
        (recruteur_nom, pseudo_discord, id_discord, duree_entretien, presentation,
         definition_bon_staff, pourquoi_lui, note, avis_final, commentaire)
     VALUES
        (:recruteur_nom, :pseudo_discord, :id_discord, :duree_entretien, :presentation,
         :definition_bon_staff, :pourquoi_lui, :note, :avis_final, :commentaire)'
);

$stmt->execute([
    ':recruteur_nom'        => $_SESSION['recruteur_nom'] ?? 'Recruteur',
    ':pseudo_discord'       => trim($_POST['pseudo_discord'] ?? ''),
    ':id_discord'           => trim($_POST['id_discord'] ?? ''),
    ':duree_entretien'      => trim($_POST['duree_entretien'] ?? ''),
    ':presentation'         => trim($_POST['presentation'] ?? ''),
    ':definition_bon_staff' => trim($_POST['definition_bon_staff'] ?? ''),
    ':pourquoi_lui'         => trim($_POST['pourquoi_lui'] ?? ''),
    ':note'                 => $note,
    ':avis_final'           => $avis,
    ':commentaire'          => trim($_POST['commentaire'] ?? ''),
]);

header('Location: /recruteur/rapport.php?success=1');
exit;
