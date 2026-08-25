<?php
/**
 * includes/auth.php
 * Fonctions de vérification de session
 */

function isRecruteur() {
    return isset($_SESSION['role']) && ($_SESSION['role'] === 'recruteur' || $_SESSION['role'] === 'admin');
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function requireRecruteur() {
    if (!isRecruteur()) {
        header('Location: /login_recruteur.php');
        exit;
    }
}

function requireAdmin() {
    if (!isAdmin()) {
        header('Location: /login_admin.php');
        exit;
    }
}
