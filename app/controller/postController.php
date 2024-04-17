<?php
require_once 'config/database.php';

class postController {
    public function index() {
        global $pdo;

        try {
            $query = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
            $posts = $query->fetchAll(PDO::FETCH_ASSOC);

            // Traitement des données récupérées, affichage des vues, etc.
        } catch(PDOException $e) {
            die("Erreur lors de la récupération des articles : " . $e->getMessage());
        }
    }

    // Autres méthodes de contrôleur pour afficher un article, ajouter un article, etc.
}