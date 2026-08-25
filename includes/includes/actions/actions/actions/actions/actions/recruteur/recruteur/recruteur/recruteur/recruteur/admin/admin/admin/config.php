<?php
/**
 * config.php
 * Connexion à la base de données + démarrage de session
 * + initialisation automatique des mots de passe par défaut
 */

// ---- Paramètres de connexion à adapter selon votre hébergement ----
define('DB_HOST', 'localhost');
define('DB_NAME', 'discord_recrutement');
define('DB_USER', 'root');
define('DB_PASS', '');

// ---- Mots de passe par défaut (utilisés UNE SEULE FOIS à l'installation) ----
define('DEFAULT_RECRUTEUR_PASSWORD', 'recruteur123');
define('DEFAULT_ADMIN_PASSWORD', 'admin123');

session_start();

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . htmlspecialchars($e->getMessage()));
}

// ---- Initialisation automatique des mots de passe par défaut ----
$stmt = $pdo->query('SELECT COUNT(*) AS nb FROM settings');
$row = $stmt->fetch();

if ((int)$row['nb'] === 0) {
    $insert = $pdo->prepare(
        'INSERT INTO settings (recruteur_password_hash, admin_password_hash) VALUES (:r, :a)'
    );
    $insert->execute([
        ':r' => password_hash(DEFAULT_RECRUTEUR_PASSWORD, PASSWORD_BCRYPT),
        ':a' => password_hash(DEFAULT_ADMIN_PASSWORD, PASSWORD_BCRYPT),
    ]);
}

// Fonction utilitaire d'échappement rapide
function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
