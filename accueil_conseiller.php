<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Acceuil</title>
    <meta charset="utf-8">
    <link rel="stylesheet"  href="style_agent.css" />
</head>
<body>




<?php

session_start();

require_once('connect.php'); // Vérifiez si votre fichier de connexion est correctement inclus
$connexion = new PDO('mysql:host=' . SERVEUR . ';dbname=' . BDD, USER, PASSWORD);
$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$connexion->query("SET NAMES UTF8"); // Utilisez query() pour exécuter une requête non préparée



$menu= '<header>';
$menu.= '    <nav> ';
$menu.= '    <ul class="menu-list">';

$menu.= '      <li>';
$menu.= '       <form method="post" action="accueil_conseiller.php">';
$menu.= '          <input class="accueil" type="submit" value="Accueil" name="accueil">';
$menu.= '          <input class="accueil" type="submit" value="Changer de client" name="changer_client">';
$menu.= '        </form>';
$menu.= '      </li>';

$menu.= '      <li class="menu-item"> Profil ';
$menu.= '        <ul class="submenu">';
$menu.= '          <li>';
$menu.= '            <form action="accueil_conseiller.php" method="post">';
$menu.= '              <input type="submit" value="Voir le profil" name="voir_profil"/>';
$menu.= '            </form>';
$menu.= '          </li>';
$menu.= '          <li>';
$menu.= '            <form action="accueil_conseiller.php" method="post">';
$menu.= '              <input type="submit" value="Modifier le profil" name="modifier_profil"/>';
$menu.= '            </form>';
$menu.= '          </li>';
$menu.= '        </ul>';
$menu.= '      </li>';

$menu.= '      <li class="menu-item"> Contrat ';
$menu.= '        <ul class="submenu">';
$menu.= '           <li>';
$menu.= '            <form action="accueil_conseiller.php" method="post">';
$menu.= '              <input type="submit" value="Vendre un contrat" name="vendre_contrat"/>';
$menu.= '            </form>';
$menu.= '          </li>';
$menu.= '           <li>';
$menu.= '            <form action="accueil_conseiller.php" method="post">';
$menu.= '              <input type="submit" value="Résilier un contrat" name="resilier_contrat"/>';
$menu.= '            </form>';
$menu.= '          </li>';
$menu.= '        </ul>';
$menu.= '      </li>';

$menu.= '      <li class="menu-item"> Compte';
$menu.= '        <ul class="submenu">';
$menu.= '          <li>';
$menu.= '            <form action="accueil_conseiller.php" method="post">';
$menu.= '              <input type="submit" value="Modifier la valeur d\'un découvert" name="modifier_decouvert"/>';
$menu.= '            </form>';
$menu.= '          </li>';
$menu.= '          <li>';
$menu.= '            <form action="accueil_conseiller.php" method="post">';
$menu.= '              <input type="submit" value="Ouvrir un compte" name="ouvrir_compte"/>';
$menu.= '            </form>';
$menu.= '          </li>';
$menu.= '          <li>';
$menu.= '            <form action="accueil_conseiller.php" method="post">';
$menu.= '              <input type="submit" value="Résilier un compte" name="resilier_compte"/>';
$menu.= '            </form>';
$menu.= '          </li>';
$menu.= '        </ul>';
$menu.= '      </li>';

$menu.= '    </ul>';
$menu.= '   </nav>';
$menu.= '</header>'; 

//bouton planing
$planning= ' <h2>Visualiser les planings : </h2>';

$planning.= '<form class="form-container2" action="accueil_conseiller.php" method="post">';
$requete = "SELECT ID_EMPLOYE, NOM_EMPLOYE FROM employe WHERE statut='conseiller'";
$resultat = $connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$donnees = $resultat->fetchAll();

$planning.= '<p class="cote"><label for="conseiller">Choisissez un conseiller :</label>';
$planning.= '<select id="conseiller" name="conseiller"></p>';
foreach ($donnees as $donnee) {
    $planning.= '<option value="'. $donnee->ID_EMPLOYE .'">' . $donnee->NOM_EMPLOYE . '</option>';
}
$planning.= '</select>';
$planning.= '           <p class="cote"> <label> Jour :</label><input type="date" name="date" value="' . date('Y-m-d') . '" required/></p>';
$planning.= '           <input class="bouton" type="submit" value="Voir le planning" name="planning" />  ';
$planning.= '            </form>';


       

        $recherche_cli= '            <form class="form-container" action="accueil_conseiller.php" method="post">';
        $recherche_cli.= '              <input class="bouton" type="submit" value="Rechercher un client" name="rechercher_client"/>';
        $recherche_cli.= '            </form>';

        // Bounton nouv client
        $nouv_cli= '            <form class="form-container" action="accueil_conseiller.php" method="post">';
        $nouv_cli.= '              <input class="bouton" type="submit" value="Enregistrer un nouveau client" name="nouv_client"/>';
        $nouv_cli.= '            </form>';

        

        // Formulaire de recherche par ID 
        $accueil_cli= '<form class="form-container" method="post" action="accueil_conseiller.php">';
        $accueil_cli.= '    <label for="id_client">Rechercher par ID de client :</label>';
        $accueil_cli.= '    <input type="text" id="id_client" name="id_client" required>';
        $accueil_cli.= '    <input class="bouton" type="submit" value="Rechercher" name="recherche_id">';
        $accueil_cli.= ' </form>';
        
        // Formulaire de recherche par nom et date de naissance
        $accueil_nom= '<form class="form-container" method="post" action="accueil_conseiller.php">';
        $accueil_nom.= '    <label for="nom">Nom :</label>';
        $accueil_nom.= '    <input type="text" id="nom" name="nom" required>';
        $accueil_nom.= '    <label for="ddn">Date de Naissance :</label>';
        $accueil_nom.= '    <input type="date" id="ddn" name="ddn" required>';
        $accueil_nom.= '    <input class="bouton" type="submit" value="Rechercher" name="recherche_nom">';
        $accueil_nom.= '</form>';

        // Bouton accueil
        $accueil= '<header>';
        //$accueil.= '<h2>Accueil</h2>';
        //$accueil.= '      <li class="menu-item">';
        $accueil.= '       <form method="post" action="accueil_conseiller.php">';
        $accueil.= '          <input class="accueil" type="submit" value="Accueil" name="accueil">';
        $accueil.= '        </form>';
        //$accueil.= '      </li>';
        $accueil.= '</header>';


 //recuperer nom conseiller
        $id_employe = $_SESSION['id_employe'];
        $requete = "SELECT NOM_EMPLOYE FROM employe where ID_EMPLOYE='$id_employe'";
        $resultat = $connexion->query($requete);
        $ligne = $resultat->fetch(PDO::FETCH_OBJ);

        
        $accueil1= '<h3>Bienvenue, conseiller '.$ligne->NOM_EMPLOYE.'</h3>';

                

        if (isset($_POST['rechercher_client'])) {
        

            echo $accueil;

            echo $accueil_cli;
            echo $accueil_nom;

            
        }

        

        
            

        if ((!isset($_SESSION['first_load']))) {
            
            $_SESSION['first_load'] = false; // Marquer la page comme déjà chargée
            echo $accueil;
            echo $accueil1;
            echo $recherche_cli;
            echo '<br> ' , $nouv_cli; 
            echo '<br> ' ,$planning;

            
        
            
        }

        if (isset($_POST['changer_client'])){
            echo $accueil;
            echo $accueil_cli;
            echo $accueil_nom;
            echo $nouv_cli; 
        }
        
        if(isset($_POST['deconnexion'])){
            session_unset(); // Supprime toutes les variables de session
            session_destroy(); // Détruit la session actuelle
            header("Location: connexion.php"); // Redirige vers la page de connexion
            exit; // Arrête l'exécution du script après la redirection
        }
        
        
        
       


        if (isset($_POST['accueil'])) {

            echo $accueil;
            echo $accueil1;
            echo $recherche_cli;
            echo '<br> ' , $nouv_cli; 
            echo '<br> ' ,$planning;


             
        }

        if (isset($_POST['nouv_client'])){

                        $contenu= '<h2>Ajouter un nouveau client</h2>';
$contenu.= '<form class="form-container2" name="formu3" id="form3" action="accueil_conseiller.php" method="post">';
            
            $requete = "SELECT ID_EMPLOYE, NOM_EMPLOYE FROM employe WHERE statut='conseiller'";
            $resultat = $connexion->query($requete);
            $resultat->setFetchMode(PDO::FETCH_OBJ);
            $donnees = $resultat->fetchAll();
            
            $contenu.= '<p class="cote"><label for="conseiller">Choisissez un conseiller :</label>';
            $contenu.= '<select id="conseiller" name="conseiller">';
            foreach ($donnees as $donnee) {
                $contenu.= '<option value="'. $donnee->ID_EMPLOYE .'">' . $donnee->NOM_EMPLOYE . '</option>';
            }
            $contenu.= '</select></p>';
            $contenu.= '<p><label>Nom du client :</label><input name="nom" id="nom" type="text" required/></p>';
            $contenu.= '<p><label>Prenom du client :</label><input name="prenom" id="prenom" type="text" required/></p>';
            $contenu.= '<p><label>Adresse du client :</label><input name="adresse" id="adresse" type="text" required/></p>';
            $contenu.= '<p><label>Mail du client :</label><input name="mail" id="mail" type="text" required/></p>';
            $contenu.= '<p><label>Situation du client :</label><input name="situation" id="situation" type="text" required/></p>';
            $contenu.= '<p><label>Profession du client :</label><input name="profession" id="profession" type="text" required/></p>';
            $contenu.= '<p><label> Date de naissance :</label><input type="date" name="date" required/></p>';
            
            $contenu.= '<p><input class="bouton" type="submit" value="Ajouter le nouveau client" name="ajouter_client" /> </p> ';
            
            $contenu.= '</form>';
            
            echo $accueil;
            echo $contenu;
            
            }

            //enregistrement du nouveau client
            if(isset($_POST['ajouter_client'])){
                $conseiller=$_POST['conseiller'];
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $adresse = $_POST['adresse'];
                $mail = $_POST['mail'];
                $situation = $_POST['situation'];
                $profession = $_POST['profession'];
                $date = $_POST['date'];
                $date1 = new DateTime($date);

               

                 //pas de auto_increment donc recuperer le numclient a la main
                 $requete = "SELECT NUMCLIENT FROM client ORDER BY NUMCLIENT DESC LIMIT 1";
                 $resultat = $connexion->query($requete);
                 $resultat->setFetchMode(PDO::FETCH_OBJ);
                 $num = $resultat->fetch();
                 $fin=$num->NUMCLIENT +1;
 
                 $requete = "INSERT INTO client VALUES ($fin, $conseiller, '$nom', '$prenom', '$adresse', '$mail', '$situation', '" . $date1->format('Y-m-d') . "', '$profession')";
                 $resultat=$connexion->query($requete);
                 $resultat->closeCursor();
                 
                 $contenu= '<h2><p>Le client a bien été ajouté.</p></h2>';

                 echo $accueil;
                 echo $contenu;
                
            }
        
        if (isset($_POST['recherche_id'])) {
            
                $idClient =  $_POST["id_client"];
                $_SESSION['id_client'] =  $_POST["id_client"];
        
                $requete = "SELECT c.*, e.NOM_EMPLOYE 
                            FROM CLIENT c 
                            JOIN EMPLOYE e ON c.ID_EMPLOYE = e.ID_EMPLOYE 
                            WHERE c.NUMCLIENT = :id_client";
                $resultat = $connexion->prepare($requete);
                $resultat->bindParam(':id_client', $idClient);
                $resultat->execute();
        
                $rowByID = $resultat->fetch(PDO::FETCH_ASSOC);
        
                $contenu = "<form class='form-container2'><h2>Résultat de la recherche par ID</h2>";
                $contenu .= "<p>ID Client : " . $rowByID['NUMCLIENT'] . "</p>";
                $contenu .= "<p>Nom : " . $rowByID['NOM'] . "</p>";
                $contenu .= "<p>Prénom : " . $rowByID['PRENOM'] . "</p>";
                $contenu .= "<p>Conseiller : " . $rowByID['NOM_EMPLOYE'] . "</p></form>";

        
                echo $menu;
                echo $contenu;
                
            
           
        }

        if (isset($_POST['voir_profil'])) {
            $idClient = $_SESSION['id_client'];
           

            $requete = "SELECT 
            c.NUMCLIENT,
            e.NOM_EMPLOYE AS NOM_CONSEILLER,
            c.NOM,
            c.PRENOM,
            c.ADRESSE,
            c.MAIL,
            c.SITUATION,
            c.DATENAISSANCE,
            c.PROFESSION
            FROM CLIENT c 
            JOIN EMPLOYE e ON c.ID_EMPLOYE = e.ID_EMPLOYE 
            WHERE c.NUMCLIENT = :id_client";

            $resultat = $connexion->prepare($requete);
            $resultat->bindParam(':id_client', $idClient);
            $resultat->execute();

            $rowByID = $resultat->fetch(PDO::FETCH_ASSOC);

            



            // Afficher les informations du client
            $contenu="<h2>Profil du Client</h2>";


            $contenu.= "<form class='form-container2'><p>Nom du conseiller : " . $rowByID['NOM_CONSEILLER'] . "</p>";
            $contenu.= "<p>Nom : " . $rowByID['NOM'] . "</p>";
            $contenu.= "<p>Prénom : " . $rowByID['PRENOM'] . "</p>";
            $contenu.= "<p>Adresse : " . $rowByID['ADRESSE'] . "</p>";
            $contenu.= "<p>Mail : " . $rowByID['MAIL'] . "</p>";
            $contenu.= "<p>Situation : " . $rowByID['SITUATION'] . "</p>";
            $contenu.= "<p>Date de naissance : " . $rowByID['DATENAISSANCE'] . "</p>";
            $contenu.= "<p>Profession : " . $rowByID['PROFESSION'] . "</p></form>";
            
            $requete = "SELECT * FROM `compteclient` where numclient='$idClient'";
            $resultat = $connexion->query($requete);
            $resultat->setFetchMode(PDO::FETCH_OBJ);
           
            if ($resultat->rowCount() === 0){
                $contenu.='<h2>Ce client ne possède pas de compte.</h2>';
            }
            else{
                $ligne1 = $resultat->fetchall();
                $contenu.="<h2>Compte(s) du client :</h2>";
                $contenu.= '<table class="form-container2">';
                $contenu.= '<tr><th>Nom du compte</th> <th>Solde</th> <th>Montant de decouvert</th></tr>';
                $contenu.= '<tr>';
                foreach ($ligne1 as $donnee) {
                    $contenu .= '<tr><th>' . $donnee->NOMCOMPTE . '</th> <th>' . $donnee->SOLDE . '€</th> <th>' . $donnee->MONTANTDECOUVERT . '€</th></tr>';
                }
                $contenu.= '</tr></table>';
            }

            $requete = "SELECT * FROM `contatclient` where numclient='$idClient'";
            $resultat = $connexion->query($requete);
            $resultat->setFetchMode(PDO::FETCH_OBJ);
            if ($resultat->rowCount() === 0){
                
                $contenu.='<h2>Ce client ne possède pas de contrat.</h2>';
            }
            else{
                $ligne1 = $resultat->fetchall();
                $contenu.="<h2>Contrat(s) du client :</h2>";
                $contenu.= '<table class="form-container2">';
                $contenu.= '<tr><th>Nom du contrat</th> <th>Tarif mensuel</th> <th>Date d\'ouverture</th></tr>';
                $contenu.= '<tr>';
                foreach ($ligne1 as $donnee) {
                    $contenu .= '<tr><th>' . $donnee->NOM_CONTRAT . '</th> <th>' . $donnee->TARIFMENSUEL . '€</th> <th>' . $donnee->DATEOUVERTURECONTRAT . '</th></tr>';
                }
                $contenu.= '</tr></table>';
            }



            echo $menu;
            echo $contenu;
        }


        if (isset($_POST['modifier_profil'])) {

            $idClient = $_SESSION['id_client'];

            $requete = "SELECT 
            c.NUMCLIENT,
            e.NOM_EMPLOYE AS NOM_CONSEILLER,
            c.NOM,
            c.PRENOM,
            c.ADRESSE,
            c.MAIL,
            c.SITUATION,
            c.DATENAISSANCE,
            c.PROFESSION
            FROM CLIENT c 
            JOIN EMPLOYE e ON c.ID_EMPLOYE = e.ID_EMPLOYE 
            WHERE c.NUMCLIENT = :id_client";

            $resultat = $connexion->prepare($requete);
            $resultat->bindParam(':id_client', $idClient);
            $resultat->execute();

            $rowByID = $resultat->fetch(PDO::FETCH_ASSOC);

        

            // Afficher les informations du client
            $contenu="<h2>Profil du client</h2>";
            $contenu.= "<form class='form-container2'><p>Nom du conseiller : " . $rowByID['NOM_CONSEILLER'] . "</p>";
            $contenu.= "<p>Nom : " . $rowByID['NOM'] . "</p>";
            $contenu.= "<p>Prénom : " . $rowByID['PRENOM'] . "</p>";
            $contenu.= "<p>Adresse : " . $rowByID['ADRESSE'] . "</p>";
            $contenu.= "<p>Mail : " . $rowByID['MAIL'] . "</p>";
            $contenu.= "<p>Situation : " . $rowByID['SITUATION'] . "</p>";
            $contenu.= "<p>Date de naissance : " . $rowByID['DATENAISSANCE'] . "</p>";
            $contenu.= "<p>Profession : " . $rowByID['PROFESSION'] . "</p></form>";

        

            // Afficher les informations du client que l'on souhaite mofidier
            $contenu.= "<h2>Modifier Le Profil</h2>";
            $contenu.= "<form class='form-container2' method='post' action='accueil_conseiller.php'>";
            $contenu.= "<input type='hidden' name='num_client' value='" . $idClient . "'>";
            $contenu.= "<p>Nom du conseiller : " . $rowByID['NOM_CONSEILLER'] . "</p>";
            $contenu.= "<p>Nom : <input type='text' name='nom' value='" . $rowByID['NOM'] . "'></p>";
            $contenu.= "<p>Prénom : <input type='text' name='prenom' value='" . $rowByID['PRENOM'] . "'></p>";
            $contenu.= "<p>Adresse : <input type='text' name='adresse' value='" . $rowByID['ADRESSE'] . "'></p>";
            $contenu.= "<p>Mail : <input type='text' name='mail' value='" . $rowByID['MAIL'] . "'></p>";
            $contenu.= "<p>Situation : <input type='text' name='situation' value='" . $rowByID['SITUATION'] . "'></p>";
            $contenu.= "<p>Date de naissance : <input type='date' name='datenaissance' value='" . $rowByID['DATENAISSANCE'] . "'></p>";
            $contenu.= "<p>Profession : <input type='text' name='profession' value='" . $rowByID['PROFESSION'] . "'></p>";
            $contenu.= "<p><input class='bouton' type='submit' value='Enregistrer les modifications' name='modification'></p>";
            $contenu.= "</form>";

            echo $menu;
            echo $contenu;
        }

        if (isset($_POST['modification'])) {
            $idClient = $_SESSION['id_client'];
    
    
            // Récupérer les nouvelles informations du formulaire
            $nouveauNom = $_POST['nom'];
            $nouveauPrenom = $_POST['prenom'];
            $nouvelleAdresse = $_POST['adresse'];
            $nouveauMail = $_POST['mail'];
            $nouvelleSituation = $_POST['situation'];
            $nouvelleDateNaissance = $_POST['datenaissance'];
            $nouvelleProfession = $_POST['profession'];
    
            // Mettre à jour les informations du client dans la base de données
            $queryUpdate = "UPDATE CLIENT 
                            SET NOM = :nouveau_nom, 
                                PRENOM = :nouveau_prenom, 
                                ADRESSE = :nouvelle_adresse, 
                                MAIL = :nouveau_mail, 
                                SITUATION = :nouvelle_situation, 
                                DATENAISSANCE = :nouvelle_date_naissance, 
                                PROFESSION = :nouvelle_profession
                            WHERE NUMCLIENT = :selected_client";
    
            $stmtUpdate = $connexion->prepare($queryUpdate);
            $stmtUpdate->bindParam(':nouveau_nom', $nouveauNom);
            $stmtUpdate->bindParam(':nouveau_prenom', $nouveauPrenom);
            $stmtUpdate->bindParam(':nouvelle_adresse', $nouvelleAdresse);
            $stmtUpdate->bindParam(':nouveau_mail', $nouveauMail);
            $stmtUpdate->bindParam(':nouvelle_situation', $nouvelleSituation);
            $stmtUpdate->bindParam(':nouvelle_date_naissance', $nouvelleDateNaissance);
            $stmtUpdate->bindParam(':nouvelle_profession', $nouvelleProfession);
            $stmtUpdate->bindParam(':selected_client', $idClient);
            $stmtUpdate->execute();
            
            echo $menu;
            echo "<h2>Profil mis à jour avec succès.</h2>";
    
        



        

            
            echo $contenu;
        }

       


        // FORMULAIRE RECHERCHE NOM
        if (isset($_POST['recherche_nom'])) {
            if (!empty($_POST["nom"]) && !empty($_POST["ddn"])) {
                // Requête par Nom et Date de naissance
                $nom = $_POST["nom"];
                $ddn = $_POST["ddn"];
        
                $requete = "SELECT NUMCLIENT, NOM, PRENOM, ADRESSE FROM CLIENT WHERE NOM = :nom AND DATENAISSANCE = :ddn";
                $resultat = $connexion->prepare($requete);
                $resultat->bindParam(':nom', $nom);
                $resultat->bindParam(':ddn', $ddn);
                $resultat->execute();
                
                $donnees = $resultat->fetchAll(PDO::FETCH_ASSOC);
                
                if ($donnees != null){
                $contenu = "<h2>Résultats de la recherche par Nom et Date de Naissance</h2>";
                $contenu .= "<form class='form-container2'><ul>";
        
                foreach ($donnees as $donnee) {
                    $contenu .= '<li>ID Client : ' . $donnee['NUMCLIENT'] . ', Nom : ' . $donnee['NOM'] . ', Prénom : ' . $donnee['PRENOM'] . ', Adresse : ' . $donnee['ADRESSE'] . '</li>';
                }
        
                $contenu .= "</ul></form>";
            }else{
                
                $contenu="<p class='error'>Nom ou date de naissance incorrect.</p>";
            }
            } else {
                
                $contenu = "<p class='error'>Veuillez fournir le Nom et la Date de Naissance pour effectuer une recherche.</p>";
            }
            $_SESSION['first_load'] = false;

            echo $accueil;
            echo $accueil_cli;
            echo $accueil_nom;
            echo $contenu;
        }


        // VENDRE CONTRAT

        if (isset($_POST['vendre_contrat'])) {

            $idClient = $_SESSION['id_client'];

            // Recuperer les contrats
            $requete = "SELECT * FROM CONTRAT";
            $resultat = $connexion->query($requete);
            $resultat->setFetchMode(PDO::FETCH_OBJ);
            $donnees = $resultat->fetchAll();
        

            // Formulaire liste contrat
            $contenu=  '<label><h2>Vendre un nouveau Contrat</h2></label>';
            $contenu.=  '<form class="form-container2" name="formu" id="form1" action="accueil_conseiller.php" method="post">';


            // Liste des contrats
            $contenu.=  '<p class="cote"><label for="contrat">Choisissez un contrat :</label>';
            $contenu.=  '<select id="contrat" name="contrat">';
                     foreach ($donnees as $donnee) {
            $contenu.=          '<option value="'. $donnee->NOM_CONTRAT .'">' . $donnee->NOM_CONTRAT . '</option>'; }
            $contenu.=  '</select></p>';

            // Formulaire pour le tarif mensuel
            $contenu.=  '<p class="cote"><label for="tarif_mensuel">Tarif Mensuel :</label>';
            $contenu.=  '<input type="text" id="tarif_mensuel" name="tarif_mensuel" required></p>';

            // Bouton valider
            $contenu.=  '<p><input class="bouton" type="submit" value="Valider le contrat" name="envoyer" /> </p> ';
            $contenu.=  '</form>';

            echo $menu;
            echo $contenu;

        }

        if (isset($_POST['envoyer'])) {
            $idClient = $_SESSION['id_client'];
    
    
            // Récupérer les données du formulaire
            $selectedContrat = $_POST['contrat'];
            $tarifMensuel = $_POST['tarif_mensuel'];

            // Récupérer la date d'ouverture du contrat (utilisez la date actuelle)
            $dateOuvertureContrat = date('Y-m-d');

            // Vérifier si le client a déjà ce contrat
            $requeteVerification = "SELECT COUNT(*) AS nb_contrats FROM CONTATCLIENT WHERE NUMCLIENT = :num_client AND NOM_CONTRAT = :nom_contrat";
            $stmtVerification = $connexion->prepare($requeteVerification);
            $stmtVerification->bindParam(':num_client', $idClient);
            $stmtVerification->bindParam(':nom_contrat', $selectedContrat);
            $stmtVerification->execute();
            $resultVerification = $stmtVerification->fetch(PDO::FETCH_ASSOC);

            if ($resultVerification['nb_contrats'] > 0) {
                // Le client a déjà ce contrat
                echo $menu;
                echo "<h2>Le client a déjà ce contrat.</h2>";
            } else {

            // Insérer les données dans la table CONTATCLIENT
            $requete = "INSERT INTO CONTATCLIENT (NUMCLIENT, NOM_CONTRAT, DATEOUVERTURECONTRAT, TARIFMENSUEL)
                                VALUES (:num_client, :nom_contrat, :date_ouverture_contrat, :tarif_mensuel)";

            $stmtInsertContrat = $connexion->prepare($requete);
            $stmtInsertContrat->bindParam(':num_client', $idClient);
            $stmtInsertContrat->bindParam(':nom_contrat', $selectedContrat);
            $stmtInsertContrat->bindParam(':date_ouverture_contrat', $dateOuvertureContrat);
            $stmtInsertContrat->bindParam(':tarif_mensuel', $tarifMensuel);
            $stmtInsertContrat->execute();

            
            
            echo $menu;
            

            
            echo "<h2>Contrat vendu avec succès.</h2>";
            }
        }

        // RESILIER CONTRAT

        if (isset($_POST['resilier_contrat'])) {

            $idClient = $_SESSION['id_client'];

            // Recuperer les contrats du client
            $requete = "SELECT * FROM CONTATCLIENT WHERE NUMCLIENT = :num_client";
            $stmtContrats = $connexion->prepare($requete);
            $stmtContrats->bindParam(':num_client', $idClient);
            $stmtContrats->execute();
            $donnees = $stmtContrats->fetchAll(PDO::FETCH_OBJ);

            if ($donnees == null){
                $contenu= ' Ce client n\'a pas de contrat.';                       
            }

            else{

            // Formulaire liste contrat
            $contenu=  '<h2>Résilier un Contrat</h2>';
            $contenu.= '<form class="form-container2" name="formu" id="form1" action="accueil_conseiller.php?selected_client=' . $idClient . '" method="post">';

            // Liste des contrats
            $contenu.=  '<p clas="cote"><label for="contrat">Choisissez un contrat :</label>';
            $contenu.=  '<select id="contrat" name="contrat">';
                foreach ($donnees as $donnee) {
            $contenu.=      '<option value="'. $donnee->NOM_CONTRAT .'">' . $donnee->NOM_CONTRAT . '</option>';
            }
            $contenu.= '</select><p/>';

            // Bouton valider
            $contenu.=  '<p><input class="bouton" type="submit" value="Résilier le contrat" name="supprimer" /> </p> ';
            $contenu.=  '</form>';
        
        }
            echo $menu;
            echo $contenu;
        }

        if (isset($_POST['supprimer'])) {
            $idClient = $_SESSION['id_client'];
    
    
            // Supprimer le contrat de la table CONTATCLIENT
            $requete = "DELETE FROM CONTATCLIENT WHERE NUMCLIENT = :num_client AND NOM_CONTRAT = :nom_contrat";

            $stmtDeleteContrat = $connexion->prepare($requete);
            $stmtDeleteContrat->bindParam(':num_client', $idClient);
            $stmtDeleteContrat->bindParam(':nom_contrat', $_POST['contrat']);
            $stmtDeleteContrat->execute();

            
            echo $menu;
            

            echo "<h2>Contrat résilié avec succès.</h2>";
        
        }


        // OUVRIR UN COMPTE
        if (isset($_POST['ouvrir_compte'])) {
            $idClient = $_SESSION['id_client'];

            // Récupérer les types de comptes disponibles
            $requeteTypesComptes = "SELECT * FROM COMPTE";
            $resultatTypesComptes = $connexion->query($requeteTypesComptes);
            $typesComptes = $resultatTypesComptes->fetchAll(PDO::FETCH_OBJ);


            // Formulaire pour choisir le type de compte
            $contenu= '<h2>Ouvrir un compte</h2>';
            $contenu.= '<form class="form-container2" name="ouvrir_compte" id="ouvrir_compte" action="accueil_conseiller.php" method="post">';

           $contenu.= '<p class="cote"><label for="type_compte">Choisissez le type de compte :</label>';
           $contenu.= '<select id="type_compte" name="type_compte">';
           foreach ($typesComptes as $typeCompte) {
               $contenu.= '<option value="'. $typeCompte->NOMCOMPTE .'">' . $typeCompte->NOMCOMPTE . '</option>';
           }
           $contenu.= '</select></p>';

           // Formulaire pour le solde initial
           $contenu.= '<p class="cote"><label for="solde_initial">Solde initial :</label>';
           $contenu.= '<input type="text" id="solde_initial" name="solde_initial" required>';
           $contenu.= '</p>';

           // Formulaire pour le montant de découvert
           $contenu.= '<p class="cote"><label for="montant_decouvert">Montant de découvert autorisé :</label>';
           $contenu.= '<input type="text" id="montant_decouvert" name="montant_decouvert">';
           $contenu.= '</p>';

           // Bouton valider
           $contenu.= '<p><input class="bouton" type="submit" value="Ouvrir le compte" name="valider_compte" /> </p>';
           $contenu.= '</form>';

           
            echo $menu;
            echo $contenu;
        }

            // Traitement des données soumises
            if (isset($_POST['valider_compte'])) {
                $idClient = $_SESSION['id_client'];


                //Récup les données du fromulaire
                $selectedTypeCompte = $_POST['type_compte'];
                $soldeInitial = $_POST['solde_initial'];
                $montantDecouvert = isset($_POST['montant_decouvert']) ? $_POST['montant_decouvert'] : null;

                // Date d'ouverture du compte (utilisez la date actuelle)
                $dateOuvertureCompte = date('Y-m-d');

                 // Vérifier si le client possède déjà ce type de compte
                $requeteVerification = "SELECT COUNT(*) AS nb_comptes FROM COMPTECLIENT WHERE NOMCOMPTE = :nom_compte AND NUMCLIENT = :num_client";
                $stmtVerification = $connexion->prepare($requeteVerification);
                $stmtVerification->bindParam(':nom_compte', $selectedTypeCompte);
                $stmtVerification->bindParam(':num_client', $idClient);
                $stmtVerification->execute();
                $resultVerification = $stmtVerification->fetch(PDO::FETCH_ASSOC);

                if ($resultVerification['nb_comptes'] > 0) {
                    echo $menu;
                    // Le client possède déjà ce type de compte
                    echo "<h2 class='error'>!! Compte non ouvert. Le client possède déjà ce type de compte.</h2>";
                    $idClient = $_SESSION['id_client'];

                        // Récupérer les types de comptes disponibles
                        $requeteTypesComptes = "SELECT * FROM COMPTE";
                        $resultatTypesComptes = $connexion->query($requeteTypesComptes);
                        $typesComptes = $resultatTypesComptes->fetchAll(PDO::FETCH_OBJ);


 // Formulaire pour choisir le type de compte
            $contenu= '<h2>Ouvrir un compte</h2>';
            $contenu.= '<form class="form-container2" name="ouvrir_compte" id="ouvrir_compte" action="accueil_conseiller.php" method="post">';

           $contenu.= '<p class="cote"><label for="type_compte">Choisissez le type de compte :</label>';
           $contenu.= '<select id="type_compte" name="type_compte">';
           foreach ($typesComptes as $typeCompte) {
               $contenu.= '<option value="'. $typeCompte->NOMCOMPTE .'">' . $typeCompte->NOMCOMPTE . '</option>';
           }
           $contenu.= '</select></p>';

           // Formulaire pour le solde initial
           $contenu.= '<p class="cote"><label for="solde_initial">Solde initial :</label>';
           $contenu.= '<input type="text" id="solde_initial" name="solde_initial" required>';
           $contenu.= '</p>';

           // Formulaire pour le montant de découvert
           $contenu.= '<p class="cote"><label for="montant_decouvert">Montant de découvert autorisé :</label>';
           $contenu.= '<input type="text" id="montant_decouvert" name="montant_decouvert">';
           $contenu.= '</p>';

           // Bouton valider
           $contenu.= '<p><input class="bouton" type="submit" value="Ouvrir le compte" name="valider_compte" /> </p>';
           $contenu.= '</form>';

            echo $contenu;


                } else {

                    // Insérer les données dans la table COMPTECLIENT
                    $requeteInsertCompte = "INSERT INTO COMPTECLIENT (NOMCOMPTE, NUMCLIENT, DATEOUVERTURE, SOLDE, MONTANTDECOUVERT)
                                            VALUES (:nom_compte, :num_client, :date_ouverture, :solde_initial, :montant_decouvert)";
                    $stmtInsertCompte = $connexion->prepare($requeteInsertCompte);
                    $stmtInsertCompte->bindParam(':nom_compte', $selectedTypeCompte);
                    $stmtInsertCompte->bindParam(':num_client', $idClient);
                    $stmtInsertCompte->bindParam(':date_ouverture', $dateOuvertureCompte);
                    $stmtInsertCompte->bindParam(':solde_initial', $soldeInitial);
                    $stmtInsertCompte->bindParam(':montant_decouvert', $montantDecouvert);
                    $stmtInsertCompte->execute();

                
                echo $menu;
                echo "<h2>Compte ouvert avec succès.</h2>";
                }
            }

            if (isset($_POST['planning'])) {
                
                if ((isset($_POST['conseiller'])) && ((isset($_POST['date'])))){
                    $_SESSION['conseiller']=$_POST['conseiller'];
                    $_SESSION['date']=$_POST['date'];
                    
                    $id_conseiller = $_SESSION['conseiller'];
                    $date = $_SESSION['date'];
                }
                else{
                    $id_conseiller = $_SESSION['conseiller'];
                    $date = $_SESSION['date'];

                } 

                
                
                        
                
                //recuperer nom du conseiller
                $requete = "SELECT NOM_EMPLOYE FROM employe where ID_EMPLOYE='$id_conseiller'";
                $resultat = $connexion->query($requete);
                $ligne = $resultat->fetch(PDO::FETCH_OBJ);
    
                
    
               
    
    
                $contenu= '<table class="form-container3">';
                $contenu.= '<tr><th colspan="7">Planning de '. $ligne->NOM_EMPLOYE .'</th></tr>';
                $contenu.= '<tr>';
                
                $contenu.= '<td>'. $date. '</br> <hr />';

                // Préparation de la requête SQL une fois avant la boucle
                $requete = "SELECT DISTINCT ID_RDV, DATE_RDV, NUMCLIENT, ID_MOTIF FROM rdv NATURAL JOIN employe WHERE DATE_RDV = :dateHeureString AND employe.ID_EMPLOYE = :id_conseiller ORDER BY DATE_RDV";
                $stmt = $connexion->prepare($requete);
                $stmt->bindParam(':id_conseiller', $id_conseiller);

                for ($i = 8; $i <= 18; $i++) {
                    $heurePadded = str_pad($i, 2, "0", STR_PAD_LEFT); // Formatage de l'heure
                    $dateHeureString = $date . ' ' . $heurePadded . ':00:00';
                    $dateHeure = new DateTime($dateHeureString); // Création d'un objet DateTime
                
                    // Liaison de la variable :dateHeureString à la requête préparée
                    $stmt->bindParam(':dateHeureString', $dateHeureString); // Ajout de cette ligne
                
                    // Exécution de la requête
                    $stmt->execute();
                    $donnees = $stmt->fetchAll(PDO::FETCH_OBJ);

                    if (empty($donnees)) {
                        $contenu .= "Pas de rendez-vous pour l'heure $heurePadded:00<br><hr/>";
                    } else {
                        foreach ($donnees as $row) {
                            if (isset($row->ID_MOTIF)){
                                $contenu.= '<form name="formu1" id="form1" action="accueil_conseiller.php" method="post">';
                                    $contenu.= '<input type="hidden" name="numcli" value="'.$row->NUMCLIENT.'">';
                                    $contenu.= '<input type="hidden" name="motif" value="'.$row->ID_MOTIF.'">';
                                    $contenu.= '<input type="hidden" name="idrdv" value="'.$row->ID_RDV.'">';

                                if (isset($row->NUMCLIENT)) {
                                    $requete = "SELECT DISTINCT prenom FROM client WHERE NUMCLIENT='$row->NUMCLIENT'";
                                $resultat = $connexion->query($requete);
            
                                    $rowclient = $resultat->fetch(PDO::FETCH_OBJ);
                                    $contenu.= $dateHeure->format('H:i') . '<br/> client : ' . $rowclient->prenom ;
                                    $contenu.= '<p><input type="submit" value="plus... " name="plus" /> </p> ';
                                    }else{
                                        $contenu .= $dateHeure->format('H:i') . '<br/> Client : nouveau client';
                                    }
                               
            
                                    //bouton de synsthese
                                   
                                    
                                    $contenu.= '<p><input type="submit" value="supprimer le créneau " name="supp_creneau" /> </p> ';
                                    $contenu.= '</form> <hr />';
                            } else {
                                $contenu.=  $dateHeure->format('H:i') . '<br/> Tâches administratives <hr />';
                            }
                        }
                    }
                }
                
            
                $contenu.= '</td>';
                    
                $contenu.= '</tr>';
                $contenu.= '</table>';
                
                $contenu.= '<h2>Se bloquer un créneau (Tâches administratives)</h2>';
                $contenu.= '<form class="form-container" name="formu2" id="form2" action="accueil_conseiller.php" method="post">';
    
                $requete = "SELECT ID_EMPLOYE, NOM_EMPLOYE FROM employe WHERE statut='conseiller'";
                $resultat = $connexion->query($requete);
                $resultat->setFetchMode(PDO::FETCH_OBJ);
                $donnees = $resultat->fetchAll();
        
    
                $contenu.= '<label for="date">Date :</label>
                <input type="date" id="date" name="date" required><br>
            
                <label for="heure">Heure :</label>
                <input type="number" id="quantity" value="8" name="heure"  min="8" max="18" required><br>';
    
                $contenu.= '<p><input class="bouton" type="submit" value="Valider le créneau" name="bloquer" /> </p> ';
                $contenu.= '</form>';

               
                echo $accueil;
                echo $planning;
                echo $contenu;
                
        }

        if (isset($_POST['supp_creneau'])) {
            $id_rdv = $_POST["idrdv"];
            $requete="DELETE FROM `rdv` WHERE id_rdv='$id_rdv'";
            $resultat=$connexion->query($requete);
            $resultat->closeCursor();
            $contenu='<h2>Le créneau a bien été retiré.</h2>';

            $retour= '            <form action="accueil_conseiller.php" method="post">';
            $retour.= '              <p><input class="bouton" type="submit" value="Retour au planning" name="planning"/></p>';
            $retour.= '            </form>';

            echo $accueil;
            echo $contenu;
            echo $retour;

        }



        //dbloquer un creneau 
    if (isset($_POST['bloquer'])) {
        $id_employe = $_SESSION['id_employe'];
        $date1 = $_POST['date']; // Récupération de la valeur du champ 'date'
        $heure1 = $_POST['heure']; // Récupération de la valeur du champ 'date'

        $heure = str_pad($heure1, 2, "0", STR_PAD_LEFT); // Formatage de l'heure
        $date = $date1 . ' ' . $heure . ':00:00';
        
        
        $test=TRUE;

        $requete = "SELECT DATE_RDV FROM RDV";
        $resultat = $connexion->query($requete);
        $resultat->setFetchMode(PDO::FETCH_OBJ);
        $donnees = $resultat->fetchAll();

        foreach ($donnees as $donnee) {
            $date1 = new DateTime($date);
            $date2 = new DateTime($donnee->DATE_RDV);


            // Calculer la différence entre les deux dates
            $interval = $date1->diff($date2);
            $hours =  $interval->m + $interval->h*60 + ($interval->days *60 * 24);

            $interval2 = $date2->diff($date1);
            $hours2 = $interval2->m + $interval2->h*60 + ($interval2->days * 60 * 24);

            // Vérifier si l'heure du rendez-vous est entre 8h et 18h
            if ($date1->format('H') < 8 || $date1->format('H') >= 18) {
                $contenu= "<h2>Il faut prendre un crénau entre 8h et 18h.</h2>";
                $test=FALSE;
                break;
            }

            // Vérifier si la différence des heures est d'au moins une heure
            if ($hours<60 || $hours2<60) {
                $contenu= "<h2>Le créneau est déjà pris. </h2>";
                $test = FALSE;
                break;
            } 

        }


                if ($test){
                    //pas de auto_increment donc recuperer le id_rdv a la main
                    $requete = "SELECT ID_RDV FROM rdv ORDER BY ID_RDV DESC LIMIT 1";
                    $resultat = $connexion->query($requete);
                    $resultat->setFetchMode(PDO::FETCH_OBJ);
                    $rdv = $resultat->fetch();
                    $fin=$rdv->ID_RDV +1;

                    //ajout a la base de donnée
                    $requete="insert into rdv values ('$fin',NULL,'$id_employe',NULL,'$date')";
                    $resultat=$connexion->query($requete);
                    $resultat->closeCursor();
                    $contenu= '<h2>Le créneau a bien été bloqué.</h2>';
                    
                    
                    }

                    $retour= '            <form action="accueil_conseiller.php" method="post">';
                    $retour.= '              <p><input class = "bouton" type="submit" value="Retour au planning" name="planning"/></p>';
                    $retour.= '            </form>';

                    echo $accueil;
                    echo $contenu;
                    echo $retour;
                    
        }

        //bouton plus du planning
        if (isset($_POST['plus'])) {
            $id_employe = $_SESSION['id_employe'];
            $numcli = $_POST['numcli'];
            $motif = $_POST['motif'];

            

            $requete = "SELECT * FROM motif WHERE ID_MOTIF='$motif'";
            $resultat = $connexion->query($requete);
            $resultat->setFetchMode(PDO::FETCH_OBJ);
            $cli = $resultat->fetch();

            $requete = "SELECT * FROM client WHERE NUMCLIENT='$numcli'";
            $resultat = $connexion->query($requete);
            $resultat->setFetchMode(PDO::FETCH_OBJ);
            $rowByID = $resultat->fetch();

            $contenu='<h2>Information du rendez-vous :</h2>';
            $contenu.= '<p><form class="form-container2">Objet du rendez-vous : '.$cli->NOM_MOTIF.'</br> Pièces nécessaires : '.$cli->LITSE_PIECES;
            $contenu.= '</p></form>';

            $contenu.='<h2>Information du client :</h2>';
            $contenu.= '<form class="form-container2"><p>Nom : ' . $rowByID->NOM . '</p>';
            $contenu.= "<p>Prénom : " . $rowByID->PRENOM . "</p>";
            $contenu.= "<p>Adresse : " . $rowByID->ADRESSE . "</p>";
            $contenu.= "<p>Mail : " . $rowByID->MAIL . "</p>";
            $contenu.= "<p>Situation : " . $rowByID->SITUATION . "</p>";
            $contenu.= "<p>Date de naissance : " . $rowByID->DATENAISSANCE . "</p>";
            $contenu.= "<p>Profession : " . $rowByID->PROFESSION . "</p></form>";

            //retour au planning
            $retour= '            <form action="accueil_conseiller.php" method="post">';
            $retour.= '              <p><input class="bouton" type="submit" value="Retour au planning" name="planning"/></p>';
            $retour.= '            </form>';

            echo $accueil;
            echo $contenu;
            echo $retour;
            
            
        }


        if (isset ($_POST['modifier_decouvert'])){
            $idClient = $_SESSION['id_client'];
            $contenu= '<h2>Modifier la valeur d\'un découvert </h2>';
            $contenu.='<form class="form-container2" method="post" action="accueil_conseiller.php" >';
            
            $requete="select nomcompte from compte natural join compteclient natural join client where numclient='$idClient' ";
            $resultat=$connexion->query($requete);
            $resultat->setFetchMode(PDO::FETCH_OBJ);
            $lignes = $resultat->fetchall();

            if ($lignes == null){
                $contenu= '<h2> Ce client n\'a pas de compte.</h2>';                       
            }
            
            else {
                $contenu.= 'Le(s) compte(s) du client : ';
                $contenu.= '<select id="motif" name="motif">';
                foreach($lignes as $ligne){
                $contenu.= '<option value="'.$ligne->nomcompte.'" >'.$ligne->nomcompte.'</option>';                        
                }
            
                $contenu.= '</select>';
               
                $contenu.= '<p><input class="bouton" type="submit" value="Choisir le compte" name="changement_decouvert" /> </p> ';
                $contenu.='</form>';              
            }
            
            
            
            echo $menu;
            echo $contenu;
            }

            //selectioner changement decouvert 
        if (isset ($_POST['changement_decouvert'])){

            $idClient = $_SESSION['id_client'];
            $motif=$_POST['motif'];

            $requete='select montantdecouvert from compteclient where numclient="'.$idClient.'" and nomcompte="'.$motif.'"';
            $resultat=$connexion->query($requete);
            $resultat->setFetchMode(PDO::FETCH_OBJ);
            $inform=$resultat->fetch();

            $contenu= '<h2>Modifier la valeur d\'un découvert </h2>';

            

            $contenu.=' <form class="form-container2" method="post" action="accueil_conseiller.php">';
            $contenu.= 'Le montant du découvert est actuellement de '.-$inform->montantdecouvert.' €.';
            $contenu.= '<p class="cote"><label for="choix">Insérez la nouvelle valeur du découvert :</label>';                   
            $contenu.='<input type="entier"  name="somme">';
            $contenu.='</p> <input class="bouton" type="submit" value="Modifier le découvert" name="operation">';
            $contenu.='<input type="hidden" value="'.$motif.'" name="motif2">';
            $contenu.='</form>';
            
            echo $menu;
            echo $contenu;
                                
            }


        if (isset ($_POST['operation'])){

            $idClient = $_SESSION['id_client'];
            $motif=$_POST['motif2'];
            $somme=$_POST['somme'];
            $requete='select montantdecouvert from compteclient where numclient="'.$idClient.'" and nomcompte="'.$motif.'"';
            $resultat=$connexion->query($requete);
            $resultat->setFetchMode(PDO::FETCH_OBJ);
            $inform=$resultat->fetch();
            $inform2=$inform->montantdecouvert;
            
            $montantdecouvert='update compteclient  set montantdecouvert="'.-$somme.'" where montantdecouvert="'.$inform2.'" and numclient="'.$idClient.'" and nomcompte="'.$motif.'" ';
            $resultat2=$connexion->query($montantdecouvert);
            $resultat2->setFetchMode(PDO::FETCH_OBJ);

            echo $menu;
            echo '<h2>Le montant du découvert a bien été changé.</h2>';
        }

                // RESILIER COMPTE
        if (isset($_POST['resilier_compte'])) {
            $idClient = $_SESSION['id_client'];

            // Récupérer les comptes du client
            $requete = "SELECT * FROM COMPTECLIENT WHERE NUMCLIENT = :num_client";
            $stmtComptes = $connexion->prepare($requete);
            $stmtComptes->bindParam(':num_client', $idClient);
            $stmtComptes->execute();
            $donnees = $stmtComptes->fetchAll(PDO::FETCH_OBJ);

            if ($donnees == null){
                $contenu= '<h2>Ce client n\'a pas de compte.</h2>';                       
            }

            else{
            // Formulaire liste compte
            $contenu= '<h2>Résilier un compte</h2>';
            $contenu.= '<form class="form-container2" name="formu" id="form1" action="accueil_conseiller.php?selected_client=' . $idClient . '" method="post">';

            // Liste des comptes
            $contenu .= '<p class="cote"> <label for="compte">Choisissez un compte :</label>';
            $contenu .= '<select id="compte" name="compte">';
            foreach ($donnees as $donnee) {
                $contenu .= '<option value="'. $donnee->NOMCOMPTE .'">' . $donnee->NOMCOMPTE . '</option>';
            }
            $contenu .= '</select></p>';

            // Bouton valider
            $contenu .= '<p><input class="bouton" type="submit" value="Résilier le compte" name="supprimer_compte" /> </p> ';
            $contenu .= '</form>';
        }

            echo $menu;
            echo $contenu;
        }
        

        // Traitement de la résiliation de compte
        if (isset($_POST['supprimer_compte'])) {
            $idClient = $_SESSION['id_client'];

            // Récupérer le compte sélectionné
            $selectedCompte = $_POST['compte'];

            // Supprimer le compte de la table COMPTECLIENT
            $requete = "DELETE FROM COMPTECLIENT WHERE NUMCLIENT = :num_client AND NOMCOMPTE = :nom_compte";

            $stmtDeleteCompte = $connexion->prepare($requete);
            $stmtDeleteCompte->bindParam(':num_client', $idClient);
            $stmtDeleteCompte->bindParam(':nom_compte', $selectedCompte);
            $stmtDeleteCompte->execute();

            echo $menu;
            echo "<h2>Compte résilié avec succès.</h2>";
        }




       
        
?>





        
        
        </body>
        <footer>
        <form method="post" action="accueil_conseiller.php">
           <input class="deco" type="submit" value="Déconnexion" name="deconnexion">
        </form>

        </footer>
        </html>