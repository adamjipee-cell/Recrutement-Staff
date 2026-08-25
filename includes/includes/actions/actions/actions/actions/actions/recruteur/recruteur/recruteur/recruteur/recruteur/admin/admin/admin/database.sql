-- =====================================================
-- Base de données : Recrutement Staff Discord
-- =====================================================

CREATE DATABASE IF NOT EXISTS discord_recrutement
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE discord_recrutement;

-- -----------------------------------------------------
-- Table des paramètres (mots de passe recruteur / admin)
-- Les mots de passe sont stockés hashés (password_hash PHP).
-- Ils sont insérés automatiquement par config.php au premier
-- chargement si cette table est vide (voir instructions).
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    recruteur_password_hash VARCHAR(255) NULL,
    admin_password_hash VARCHAR(255) NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- -----------------------------------------------------
-- Table des rapports d'entretien
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS rapports (
    id INT PRIMARY KEY AUTO_INCREMENT,
    recruteur_nom VARCHAR(100) NULL,
    pseudo_discord VARCHAR(100) NOT NULL,
    id_discord VARCHAR(100) NOT NULL,
    duree_entretien VARCHAR(50) NOT NULL,
    presentation TEXT NOT NULL,
    definition_bon_staff TEXT NOT NULL,
    pourquoi_lui TEXT NOT NULL,
    note TINYINT UNSIGNED NOT NULL,
    avis_final ENUM('Favorable', 'Défavorable', 'À revoir') NOT NULL,
    commentaire TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- -----------------------------------------------------
-- Table des questions du quiz de formation
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS quiz_questions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    question TEXT NOT NULL,
    option_a VARCHAR(255) NOT NULL,
    option_b VARCHAR(255) NOT NULL,
    option_c VARCHAR(255) NOT NULL,
    option_d VARCHAR(255) NOT NULL,
    bonne_reponse ENUM('a','b','c','d') NOT NULL,
    ordre INT DEFAULT 0
);

-- -----------------------------------------------------
-- Table des résultats de quiz
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS quiz_resultats (
    id INT PRIMARY KEY AUTO_INCREMENT,
    recruteur_nom VARCHAR(100) NULL,
    score INT NOT NULL,
    total INT NOT NULL,
    details TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- -----------------------------------------------------
-- Insertion des 12 questions du quiz de formation
-- -----------------------------------------------------
INSERT INTO quiz_questions (question, option_a, option_b, option_c, option_d, bonne_reponse, ordre) VALUES
('Quelle est la première qualité attendue d\'un membre du staff ?', 'Être drôle', 'Être impartial et juste', 'Avoir beaucoup d\'amis sur le serveur', 'Être en ligne 24h/24', 'b', 1),
('Un membre insulte un autre membre publiquement. Que faites-vous ?', 'Vous l\'ignorez', 'Vous le sanctionnez selon le règlement après vérification', 'Vous le bannissez immédiatement sans discussion', 'Vous répondez par une autre insulte', 'b', 2),
('Pourquoi faut-il éviter le favoritisme en tant que staff ?', 'Ce n\'est pas grave si on aime bien la personne', 'Cela nuit à la crédibilité et à l\'équité du staff', 'Le favoritisme est encouragé', 'Cela n\'a aucun impact', 'b', 3),
('Que faire si vous n\'êtes pas sûr de la sanction à appliquer ?', 'Sanctionner au hasard', 'Demander l\'avis d\'un membre du staff plus expérimenté', 'Ne rien faire du tout', 'Bannir par précaution', 'b', 4),
('Un ami proche enfreint le règlement. Que faites-vous ?', 'Vous fermez les yeux car c\'est un ami', 'Vous appliquez la même sanction que pour n\'importe qui', 'Vous le prévenez en privé pour qu\'il supprime le message', 'Vous démissionnez', 'b', 5),
('Quel est le rôle principal d\'un modérateur ?', 'Divertir la communauté', 'Faire respecter le règlement et assurer un cadre sain', 'Recruter de nouveaux membres', 'Gérer les partenariats', 'b', 6),
('Comment réagir face à un membre très énervé qui insulte le staff ?', 'Rester calme, ne pas rentrer dans la provocation, appliquer les règles', 'Répondre avec la même agressivité', 'Le bannir sans explication', 'L\'ignorer complètement sans suite', 'a', 7),
('Le staff doit-il communiquer ses sanctions de manière transparente ?', 'Non, jamais', 'Oui, dans la mesure du possible et du règlement', 'Seulement si on le demande', 'Cela dépend de l\'humeur du staff', 'b', 8),
('Que représente l\'abus de pouvoir chez un staff ?', 'Une qualité recherchée', 'Une faute grave pouvant mener à un retrait du rôle', 'Un acte sans conséquence', 'Un privilège normal du rôle', 'b', 9),
('Un nouveau membre pose une question déjà répondue dans le règlement. Que faites-vous ?', 'Vous l\'ignorez car "il aurait dû lire"', 'Vous répondez poliment et le redirigez vers le règlement', 'Vous le sanctionnez pour ne pas avoir lu', 'Vous le moquez publiquement', 'b', 10),
('La discrétion sur les discussions internes du staff est-elle importante ?', 'Non, on peut tout partager', 'Oui, la confidentialité renforce la confiance de l\'équipe', 'Seulement certains sujets', 'Cela n\'a aucune importance', 'b', 11),
('Quelle qualité est essentielle pour gérer les conflits entre membres ?', 'L\'impulsivité', 'Le calme, l\'écoute et l\'objectivité', 'La rapidité sans réflexion', 'La fermeté agressive', 'b', 12);
