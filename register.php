<html>
    <head>
	    <title>Enregistrement</title>
            <meta charset="UTF-8">
            <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
        <title>Se créer un compte</title>
            <link rel="stylesheet" href="assets/formulaire_stylax.css">
    </head>

    <body>
        <form method="post" action="register.php">
            Login :<br>
            <input type="text" name="login"><br><br>

            Password :<br>
            <input type="password" name="mdp"><br><br>

            S'enregistrer :<br>
            <input type="submit" value="Envoyer"><br><br>
            <a href="log_in.php">J'ai deja un compte</a><br><br>
        <?php
            //including the database connection file
            include_once("includes/configuration.php");

            if(isset($_POST['Envoyer'])) {	
                $name = $_POST['login'];
                $age = $_POST['mdp'];
                    
                // checking empty fields
                if(empty($login) || empty($mdp)) {
                            
                    if(empty($login)) {
                        echo "<font color='red'>Name field is empty.</font><br/>";
                    }
                    
                    if(empty($mdp)) {
                        echo "<font color='red'>Age field is empty.</font><br/>";
                    }
                
                } else { 
                    // if all the fields are filled (not empty) 
                        
                    //insert data to database		
                    $sql = "INSERT INTO connecter(login, mdp) VALUES(:login, :mdp)";
                    $query = $conn->prepare($sql);
                            
                    $query->bindparam(':login', $login);
                    $query->bindparam(':mdp', $mdp);
                    $query->execute();
                    
                    // Alternative to above bindparam and execute
                    
                    //display success message
                    echo "<font color='green'>Data added successfully.";
                    echo "<br/><a href='index.php'>View Result</a>";
                }
            }
        ?>
    </body>
</html>