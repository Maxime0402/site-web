<?php
require_once "config.php";

// Vérifier si l'ID du livre est passé en paramètre
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Récupérer les informations du livre depuis la base de données
        $sql = "SELECT titre, auteur, description FROM livres WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Afficher les informations du livre
        if ($row = $stmt->fetch()) {
            echo "<h1>" . $row['titre'] . "</h1>";
            echo "<p><strong>Auteur:</strong> " . $row['auteur'] . "</p>";
            echo "<p><strong>Description:</strong> " . $row['description'] . "</p>";
        } else {
            echo "Aucun livre trouvé avec cet ID.";
        }
    } catch (PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
} else {
    echo "ID du livre non spécifié.";
}
?>
