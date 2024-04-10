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
        <p>Découvrez notre contenu passionnant</p>
    </header>
    <div class="container">
    <?php
        // Récupérer les images et les informations de la base de données en utilisant les informations de connexion du fichier configuration.php
        try {
            $sql = "SELECT id_sport, titre, auteur FROM sport"; // Modifiez la requête pour correspondre à votre base de données
            $stmt = $pdo->query($sql);

            // Afficher les images et les informations
            echo '<div class="book-container">';
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="book-item">';
                echo "<img class='book-image' src='assets/img/image_{$row['id_sport']}.png'>";
                echo '<p>' . $row['titre'] . '</p>';
                echo '<p>' . $row['auteur'] . '</p>';
                echo '<a href="nouvelle_page.php?id=' . $row['id_sport'] . '" class="more-info-btn">En savoir plus</a>';
                echo '</div>';
            }
            echo '</div>';
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    ?>
    </div>
    <footer>
        <div class="navigation">
            <button id="firstPageBtn" style="display: none;"><<</button>
            <button id="prevPageBtn"><</button>
            <span class="prev-page page-numbers" onclick="goToPage(currentPage - 1)"></span>
            <span class="current-page" onclick="goToPage(currentPage)"></span>
            <span class="next-page page-numbers" onclick="goToPage(currentPage + 1)"></span>
            <button id="nextPageBtn">></button>
            <button id="lastPageBtn">>></button>
        </div>
        <p>&copy; 2024 Mon Site Web. Tous droits réservés.</p>
    </footer>
    <script>
        var currentPage = 1; // Page actuelle

        // Mise à jour de la page actuelle après le chargement du document
        document.addEventListener("DOMContentLoaded", function() {
            updateCurrentPage();
        });

        document.getElementById("firstPageBtn").addEventListener("click", function() {
            currentPage = 1;
            updateCurrentPage();
        });

        document.getElementById("prevPageBtn").addEventListener("click", function() {
            if (currentPage > 1) {
                currentPage--;
                updateCurrentPage();
            }
        });

        document.getElementById("nextPageBtn").addEventListener("click", function() {
            // Ajoutez ici votre logique pour naviguer vers la page suivante
            currentPage++;
            updateCurrentPage();
        });

        document.getElementById("lastPageBtn").addEventListener("click", function() {
            // Ajoutez ici votre logique pour naviguer vers la dernière page
            currentPage = 5; // Exemple : si vous avez 5 pages
            updateCurrentPage();
        });

        function goToPage(page) {
            if (page >= 1 && page <= 5) { // Modifier ici pour le nombre total de pages dans votre site web
                currentPage = page;
                updateCurrentPage();
            }
        }

        function updateCurrentPage() {
            document.querySelector(".current-page").textContent = currentPage;
            document.querySelector(".prev-page").textContent = currentPage - 1 >= 1 ? currentPage - 1 : '';
            document.querySelector(".next-page").textContent = currentPage < 5 ? currentPage + 1 : '';
            
            // Mettre à jour l'URL avec le numéro de page actuel
            history.pushState({}, "", "?page=" + currentPage);

            // Cacher ou afficher les boutons en fonction de la page actuelle
            document.getElementById("firstPageBtn").style.display = currentPage === 1 ? "none" : "inline-block";
            document.getElementById("prevPageBtn").style.display = currentPage === 1 ? "none" : "inline-block";
            document.getElementById("nextPageBtn").style.display = currentPage === 5 ? "none" : "inline-block";
            document.getElementById("lastPageBtn").style.display = currentPage === 5 ? "none" : "inline-block";
        }
    </script>
</body>
</html>
