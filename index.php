<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Site Web</title>
    <link rel="stylesheet" href="assets/form.css">
</head>
<body>
    <?php include 'includes/configuration.php'; ?>
    <header>
        <h1>Bienvenue sur Mon Site Web</h1>
        <p>Découvrez nos livres passionnants sur différents sports</p>
    </header>
    <div class="container">
    <?php
        // Pagination
        $elements_par_page = 5; // Nombre d'éléments à afficher par page
        $page_actuelle = isset($_GET['page']) ? $_GET['page'] : 1; // Numéro de la page actuelle, par défaut 1

        // Calcul de l'offset
        $offset = ($page_actuelle - 1) * $elements_par_page;

         if ($page_actuelle == 1): ?>
            <a href="welcome.php" style="float: right;">Connexion</a>
        <?php endif; 

        // Récupérer les images et les informations de la base de données en utilisant les informations de connexion du fichier configuration.php
        try {
            $sql = "SELECT id_sport, titre, auteur FROM sport LIMIT $offset, $elements_par_page"; // Limiter les résultats par page
            $stmt = $conn->query($sql);

            // Afficher les images et les informations
            echo '<div class="book-container">';
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $id_livre = $row["id_sport"];
                $id_php = $id_livre . ".png";
                echo '<div class="book-item">';
                echo "<img class='book-image' src='assets/img/$id_php'>";
                echo '<p>' . $row['titre'] . '</p>';
                echo '<p>' . $row['auteur'] . '</p>';
                echo '<a href="information.php?information=' . $id_livre . '" class="more-info-btn">En savoir plus</a>';
                echo '</div>';
            }
            echo '</div>';
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }

        // Nombre total de pages
        $sql_count = "SELECT COUNT(*) AS total FROM sport";
        $stmt_count = $conn->query($sql_count);
        $total_rows = $stmt_count->fetch(PDO::FETCH_ASSOC)['total'];
        $total_pages = ceil($total_rows / $elements_par_page);

        // Afficher les liens de pagination
        echo '<div class="pagination">';
        if ($page_actuelle != 1) {
            echo '<a href="?page=1" style="font-size:1em;"> << </a>'; // Bouton pour aller à la première page
            echo '<a href="?page='.($page_actuelle - 1).'" style="font-size:1em;"> < </a>'; // Bouton pour aller à la page précédente
        }
        if ($page_actuelle > 1) {
            echo '<a href="?page='.($page_actuelle - 1).'" style="font-size:1em;">'.($page_actuelle - 1).'</a>'; // Numéro de la page précédente
        }
        echo '<span class="current-page" style="font-size:1em;">' . $page_actuelle . '</span>'; // Numéro de la page actuelle en gras
        if ($page_actuelle < $total_pages) {
            echo '<a href="?page='.($page_actuelle + 1).'" style="font-size:1em;">'.($page_actuelle + 1).'</a>'; // Numéro de la page suivante
        }
        if ($page_actuelle != $total_pages) {
            echo '<a href="?page='.($page_actuelle + 1).'" style="font-size:1em;"> > </a>'; // Bouton pour aller à la page suivante
            echo '<a href="?page='.$total_pages.'" style="font-size:1em;"> >> </a>'; // Bouton pour aller à la dernière page
        }
        echo '</div>';
    ?>
    </div>
</body>
</html>