<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information sur le livre </title>
    <link rel="stylesheet" href="assets/form.css">
</head>
<body>
    <header>
        <h1>Information sur le livre</h1>
    </header>
    <main>
        <section>
            <div class="form.css">
            <?php
                // Vérifier si le paramètre world existe dans l'URL
                if(isset($_GET['information'])) {
                    // Récupérer le nom du monde depuis l'URL
                    $id_php = $_GET['information'];

                    // Chemin vers les images
                    $image_path = 'assets/img/';

                    // Connexion à la base de données
                    $host = 'db';
                    $dbname = 'creation_web';
                    $username = 'root';
                    $password = 'root';

                    try {
                        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // Requête pour récupérer les détails du monde spécifique
                        $stmt = $conn->prepare("SELECT * FROM sport WHERE id_sport = :id_sport");
                        $stmt->bindParam(':id_sport', $id_php);
                        $stmt->execute();

                        // Afficher les détails du monde spécifique
                        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<p>Nom du livre : " . $row['titre'] . "</p>";
                            echo "<img src='$image_path$id_php' alt='" . $row['titre'] . "'>";
                            echo "<p><strong>Auteur :</strong> " . $row['auteur'] . "</p>";
                            echo "<p><strong>Description :</strong> " . $row['description'] . "</p>"; 
                        } else {
                            echo "<p>Aucun détail trouvé pour ce livre.</p>";
                        }
                    } catch(PDOException $e) {
                        echo "La connexion a échoué : " . $e->getMessage();
                    }
                } else {
                    echo "<p>Aucun monde sélectionné.</p>";
                }
            ?>
            </div>
        </section>
    </main>
    <footer>
    </footer>
    <div class="bottom-bar"></div>
</body>
</html>