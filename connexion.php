<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Connexion</title>
        <meta charset="utf-8">
        <link rel="stylesheet"  href="css.css" />

    </head>

    <body>
        <h2>Connexion</h2>

        
        <?php
        try {
            require_once('connect.php');
            $connexion = new PDO('mysql:host=' . SERVEUR . ';dbname=' . BDD, USER, PASSWORD);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connexion->query("SET NAMES UTF8");

            // Vérifier si le formulaire a été soumis
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Récupérer les valeurs des champs
                $login = $_POST["login"];
                $mdp = $_POST["mdp"];

                // Vérifier les informations de connexion
                $query = "SELECT * FROM EMPLOYE WHERE LOGIN = :login AND MOTDEPASSE = :mdp";
                $stmt = $connexion->prepare($query);
                $stmt->bindParam(':login', $login);
                $stmt->bindParam(':mdp', $mdp);
                $stmt->execute();

                // Vérifier le nombre de lignes retournées
            $rowCount = $stmt->rowCount();

            if ($rowCount > 0) {
                // Récupérer le statut de l'employé
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $statut = $result['STATUT'];
                $id_employe = $result['ID_EMPLOYE'];
                session_start();
                session_unset();
                $_SESSION['id_employe'] = $id_employe;

                // Rediriger en fonction du statut
                switch ($statut) {
                    case 'agent':
                        header("Location:accueil_agent.php");
                        break;
                    case 'conseiller':
                        header("Location:accueil_conseiller.php");
                        break;
                    case 'directeur':
                        header("Location: accueil_directeur.php");
                        break;
                    // Ajoutez d'autres cas si nécessaire
                    default:
                        echo "Statut non reconnu";
                        break;
                }
                      exit();
                } else {
                    echo "<p>Identifiants incorrects. Veuillez réessayer.</p>";
                }
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    ?>
        


        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="login">Login :</label>
            <input type="text" id="login" name="login" required>
            <br>
    
            <label for="mdp">Mot de passe :</label>
            <input type="password" id="mdp" name="mdp" required>
            <br>
    
            <input type="submit" class= "bouton" value="Se connecter">
        </form>
        
        <p>Login et mdp de connexion : <br><br>
        Conseiller : legrand legrand123 <br>
        Agent : petit   petit123 <br>
        Directeur : moreau  moreau123 <br>
        </p>
        <p>Il est possible de changer ces login et mdp sur l'interface du directeur, <br>
        !! MERCI DE NE PAS LES MODIFIER !!</p>
    

        <footer>
    </footer>
    
    </body>
</html>
