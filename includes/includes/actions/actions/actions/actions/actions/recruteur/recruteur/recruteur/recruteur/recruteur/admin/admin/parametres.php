<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();

$pageTitle = 'Paramètres';
require_once __DIR__ . '/../includes/header.php';
?>

<h1 class="page-title">Paramètres</h1>
<p class="page-subtitle">Modifiez les mots de passe d'accès recruteur et admin.</p>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success" data-autohide>Mot de passe mis à jour avec succès !</div>
<?php elseif (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        <?php
            $errors = [
                'mismatch' => "Le mot de passe actuel saisi est incorrect.",
                'confirm' => "La confirmation ne correspond pas au nouveau mot de passe.",
                'empty' => "Veuillez remplir tous les champs.",
            ];
            echo e($errors[$_GET['error']] ?? 'Une erreur est survenue.');
        ?>
    </div>
<?php endif; ?>

<div class="card">
    <h3 style="margin-bottom:16px;">🧑‍💼 Mot de passe recruteur</h3>
    <form method="post" action="/actions/change_password.php">
        <input type="hidden" name="cible" value="recruteur">
        <div class="form-row">
            <div class="form-group">
                <label>Mot de passe admin actuel (confirmation)</label>
                <input type="password" name="password_admin_actuel" required>
            </div>
            <div class="form-group">
                <label>Nouveau mot de passe recruteur</label>
                <input type="password" name="nouveau_mdp" required>
            </div>
        </div>
        <div class="form-group">
            <label>Confirmer le nouveau mot de passe</label>
            <input type="password" name="confirmer_mdp" required>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>

<div class="card mt-20">
    <h3 style="margin-bottom:16px;">🛡️ Mot de passe admin</h3>
    <form method="post" action="/actions/change_password.php">
        <input type="hidden" name="cible" value="admin">
        <div class="form-row">
            <div class="form-group">
                <label>Mot de passe admin actuel</label>
                <input type="password" name="password_admin_actuel" required>
            </div>
            <div class="form-group">
                <label>Nouveau mot de passe admin</label>
                <input type="password" name="nouveau_mdp" required>
            </div>
        </div>
        <div class="form-group">
            <label>Confirmer le nouveau mot de passe</label>
            <input type="password" name="confirmer_mdp" required>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
