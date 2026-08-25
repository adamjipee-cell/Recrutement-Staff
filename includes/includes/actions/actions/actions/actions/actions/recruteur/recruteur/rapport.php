<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/auth.php';
requireRecruteur();

$pageTitle = 'Nouveau rapport';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="flex-between">
    <div>
        <h1 class="page-title">Rapport d'entretien</h1>
        <p class="page-subtitle">Remplissez ce formulaire à l'issue de l'entretien avec le candidat.</p>
    </div>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success" data-autohide>Le rapport a été enregistré avec succès !</div>
<?php endif; ?>

<div class="card">
    <form method="post" action="/actions/submit_rapport.php">

        <div class="form-row">
            <div class="form-group">
                <label for="pseudo_discord">Pseudo Discord du candidat</label>
                <input type="text" id="pseudo_discord" name="pseudo_discord" required>
            </div>
            <div class="form-group">
                <label for="id_discord">ID Discord du candidat</label>
                <input type="text" id="id_discord" name="id_discord" required>
            </div>
        </div>

        <div class="form-group">
            <label for="duree_entretien">Durée de l'entretien</label>
            <input type="text" id="duree_entretien" name="duree_entretien" placeholder="Ex : 25 minutes" required>
        </div>

        <div class="form-group">
            <label for="presentation">Présentation du candidat</label>
            <textarea id="presentation" name="presentation" placeholder="Résumé de la présentation du candidat..." required></textarea>
        </div>

        <div class="form-group">
            <label for="definition_bon_staff">Selon lui, qu'est-ce qu'un bon staff ?</label>
            <textarea id="definition_bon_staff" name="definition_bon_staff" required></textarea>
        </div>

        <div class="form-group">
            <label for="pourquoi_lui">Pourquoi devrions-nous le prendre lui plutôt qu'un autre ?</label>
            <textarea id="pourquoi_lui" name="pourquoi_lui" required></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="note">Note sur 10</label>
                <input type="number" id="note" name="note" min="0" max="10" required>
            </div>
            <div class="form-group">
                <label for="avis_final">Avis final</label>
                <select id="avis_final" name="avis_final" required>
                    <option value="">-- Sélectionner --</option>
                    <option value="Favorable">Favorable</option>
                    <option value="Défavorable">Défavorable</option>
                    <option value="À revoir">À revoir</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="commentaire">Commentaire additionnel (optionnel)</label>
            <textarea id="commentaire" name="commentaire" placeholder="Remarques diverses..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Soumettre le rapport</button>
    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
