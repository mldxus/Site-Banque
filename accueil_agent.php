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
$menu.= '       <form method="post" action="accueil_agent.php">';
$menu.= '          <input class="accueil" type="submit" value="Accueil" name="accueil">';
$menu.= '          <input class="accueil" type="submit" value="Changer de client" name="changer_client">';
$menu.= '        </form>';
$menu.= '      </li>';

$menu.= '      <li class="menu-item">Profil';
$menu.= '        <ul class="submenu">';
$menu.= '          <li>';
$menu.= '            <form action="accueil_agent.php" method="post">';
$menu.= '              <input type="submit" value="Voir le profil" name="voir_profil"/>';
$menu.= '            </form>';
$menu.= '          </li>';
$menu.= '          <li>';

$menu.= '            <form action="accueil_agent.php" method="post">';
$menu.= '              <input type="submit" value="Modifier le profil" name="modifier_profil"/>';
$menu.= '            </form>';
$menu.= '          </li>';
$menu.= '        </ul>';
$menu.= '      </li>';
$menu.= '      <li class="menu-item">Transaction (Dépôt/Retrait)';
$menu.= '        <ul class="submenu">';
$menu.= '            <form action="accueil_agent.php" method="post">';
$menu.= '              <input type="submit" value="Effectuer une transaction" name="operation"/>';
$menu.= '            </form>';
$menu.= '        </ul>';
$menu.= '      </li>';
$menu.= '      <li class="menu-item">Synthèse Client';
$menu.= '        <ul class="submenu">';
$menu.= '          <form action="accueil_agent.php" method="post">';
$menu.= '              <input type="submit" value="Consulter les operations" name="liste_operation"/>';
$menu.= '              <input type="submit" value="Consulter les rendez-vous" name="liste_rdv"/>';
$menu.= '            </form>';

$menu.= '        </ul>';
$menu.= '      </li>';
$menu.= '    </ul>';
$menu.= '   </nav>';
$menu.= '</header>'; 


        $accueil= '<h2>Acceuil</h2>';
        $accueil.= '<h3>Bienvenue, agent</h3>';
        
        // Formulaire de recherche par ID 
        $accueil.= '<form class="form-container" method="post" action="accueil_agent.php">';
        $accueil.= '    <label for="id_client">Rechercher par ID de client :</label>';
        $accueil.= '    <input type="text" id="id_client" name="id_client" required>';
        $accueil.= '    <input class="bouton" type="submit" value="Rechercher" name="recherche_id">';
        $accueil.= ' </form>';
        
        // Formulaire de recherche par nom et date de naissance
        $accueil_nom= '<form class="form-container" method="post" action="accueil_agent.php">';
        $accueil_nom.= '    <label for="nom">Nom :</label>';
        $accueil_nom.= '    <input type="text" id="nom" name="nom" required>';
        $accueil_nom.= '    <label for="ddn">Date de Naissance :</label>';
        $accueil_nom.= '    <input type="date" id="ddn" name="ddn" required>';
        $accueil_nom.= '    <input class="bouton" type="submit" value="Rechercher" name="recherche_nom">';
        $accueil_nom.= '</form>';

        $accueil_new='<form class="form-container" method="post" action="accueil_agent.php">
                      <input class="rdv" type="submit" value="Prendre rendez-vous pour un nouveau client" name="newcli">
                      </form>';

        
            

        if ((!isset($_SESSION['first_load'])) || (isset($_POST['changer_client']))) {
            
            $_SESSION['first_load'] = false; // Marquer la page comme déjà chargée
            echo $accueil;
            echo $accueil_nom;
            echo $accueil_new;


            
        }
        
        if(isset($_POST['deconnexion'])){
            session_unset(); // Supprime toutes les variables de session
            session_destroy(); // Détruit la session actuelle
            header("Location: connexion.php"); // Redirige vers la page de connexion
            exit; // Arrête l'exécution du script après la redirection
        }
        
        
        
       


        if (isset($_POST['accueil'])) {
            $idClient = $_SESSION['id_client'];

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

            $contenu.='<form class="form-container2" action="accueil_agent.php" method="post">
            <br><p>Visualiser le planning du conseiller</p>
            <p><label> Semaine :</label>
            <input type="date" name="datedeb" value="' . date('Y-m-d') . '" required/></p>
            <p><input type="submit" value="Afficher planning du conseiller" name="afficher_planning" /></p>
            </form>';
    
            echo $menu;
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
                $contenu .= "<p>ID Client : " . $idClient . "</p>";
                $contenu .= "<p>Nom : " . $rowByID['NOM'] . "</p>";
                $contenu .= "<p>Prénom : " . $rowByID['PRENOM'] . "</p>";
                $contenu .= "<p>Conseiller : " . $rowByID['NOM_EMPLOYE'] . "</p></form>";

                $contenu.='<p><h2>Visualiser le planning du conseiller</h2></p>
                <form class="form-container" action="accueil_agent.php" method="post">
                <p><strong> Semaine </strong>:
            <input type="date" name="datedeb" value="' . date('Y-m-d') . '" required/></p>
            <p><input class="bouton" type="submit" value="Afficher planning du conseiller" name="afficher_planning" /></p>
            </form>';
        
                echo $menu;
                echo $contenu;
                
            
            }

            if(isset($_POST['newcli'])){
                $contenu= '<form class="form-container2" name="formu3" id="form3" action="accueil_agent.php" method="post">';
                $contenu.= '<label>Ajouter un rendez-vous pour un nouveau client</label>';

                $requete = "SELECT ID_EMPLOYE, NOM_EMPLOYE FROM employe WHERE statut='conseiller'";
                $resultat = $connexion->query($requete);
                $resultat->setFetchMode(PDO::FETCH_OBJ);
                $donnees = $resultat->fetchAll();

                $contenu.= '<p class="cote"><label> Semaine :</label>
                <input type="date" name="datedeb" required/></p>';

                $contenu.= '<p class="cote"><label for="conseiller">Choisissez un conseiller :</label>';
                $contenu.= '<select id="conseiller" name="conseiller">';
                foreach ($donnees as $donnee) {
                    $contenu.= '<option value="'. $donnee->ID_EMPLOYE .'">' . $donnee->NOM_EMPLOYE . '</option>';
                }
                $contenu.= '</select></p>';
                $contenu.= ' <p> <input class="bouton" type="submit" value="Voir le planning" name="newcliplan"></p>';
                $contenu.= '</form>';

                echo $accueil;
                echo $accueil_nom;
                echo $contenu;
            }

            if (isset($_POST['newcliplan'])){
                $date=$_POST['datedeb'];
                $conseiller=$_POST['conseiller'];
            
               


            if (isset($_POST['datedeb'])){
                $_SESSION['cons']=$_POST['conseiller'];
                $_SESSION['date']=$_POST['datedeb'];
                $date = $_SESSION['date'];
                $cons = $_SESSION['cons'];
            }
            else{
                $cons = $_SESSION['cons'];
                $date = $_SESSION['date'];

            }
            
            $contenu='<p><h2>Visualiser le planning du conseiller</h2></p>
            <form class="form-container" action="accueil_agent.php" method="post">
            <p><strong> Semaine </strong>:
        <input type="date" name="datedeb" value="' . date('Y-m-d') . '" required/></p>
        <input type="hidden" name="conseiller" value="'.$cons.'">
        <p><input type="submit" value="Afficher planning du conseiller" name="newcliplan" /></p>
        </form>';
       
       
        $date2 = new DateTime($date); // Utilisez la date spécifiée dans $date pour déterminer la semaine
       
        $jour_semaine = $date2->format('N');
        $date2->modify("-" . ($jour_semaine - 1) . " days"); // Début de la semaine
        $deb = $date2->format('Y-m-d');

        $requete = "SELECT * FROM `employe` WHERE ID_EMPLOYE=$cons ";
        $resultat = $connexion->query($requete);
        $resultat->setFetchMode(PDO::FETCH_OBJ);
        $ligne1 = $resultat->fetch();

        $contenu.= '<table class="form-container3">';
        $contenu.= '<tr><th colspan="7">Planning de '. $ligne1->NOM_EMPLOYE .'</th></tr>';
        $contenu.= '<tr>';
        for ($i = 1; $i <= 7; $i++) {
            

            
            //place chaque rdv dans ca case
            $contenu.= '<td>'.$deb. '</br> <hr />';

            $requete = "SELECT DISTINCT ID_RDV, DATE_RDV, NUMCLIENT, ID_MOTIF FROM rdv NATURAL JOIN employe WHERE DATE_RDV = :dateHeureString AND employe.ID_EMPLOYE = :id_conseiller ORDER BY DATE_RDV";
            $stmt = $connexion->prepare($requete);
            $stmt->bindParam(':id_conseiller', $cons);
            
            for ($j = 8; $j <= 18; $j++) {
                $heure = str_pad($j, 2, "0", STR_PAD_LEFT); // Formatage de l'heure
                $dateHeureString = $deb . ' ' . $heure . ':00:00';
                $dateHeure = new DateTime($dateHeureString); // Création d'un objet DateTime
            
                // Liaison de la variable :dateHeureString à la requête préparée
                $dateHeureString = $dateHeure->format('Y-m-d H:i:s');
                $stmt->bindParam(':dateHeureString', $dateHeureString);
                                
                // Exécution de la requête
                $stmt->execute();
                $donnees = $stmt->fetchAll(PDO::FETCH_OBJ);
            
                if (empty($donnees)) {
                    $contenu .= "$heure:00<br><br><br><hr/>";
                } else {
                    foreach ($donnees as $row) {
                        if (isset($row->ID_MOTIF)) {
                           
                            // Ajout de la requête pour récupérer le nom du motif
                                $requeteMotif = "SELECT NOM_MOTIF FROM MOTIF WHERE ID_MOTIF='$row->ID_MOTIF'";
                                $resultatMotif = $connexion->query($requeteMotif);
                                $rowMotif = $resultatMotif->fetch(PDO::FETCH_OBJ);

                                if (isset($row->NUMCLIENT)) {
                                $requeteClient = "SELECT DISTINCT prenom FROM client WHERE NUMCLIENT='$row->NUMCLIENT'";
                                $resultatClient = $connexion->query($requeteClient);
                                $rowClient = $resultatClient->fetch(PDO::FETCH_OBJ);
                                
                                $contenu .= $dateHeure->format('H:i') . '<br/> Client : ' . $rowClient->prenom . '<br/> Motif : ' . $rowMotif->NOM_MOTIF;
                                }else{
                                    $contenu .= $dateHeure->format('H:i') . '<br/> Client : nouveau client';
                                }
                                //bouton de synsthese
                                $contenu.= '<form name="formu1" id="form1" action="accueil_agent.php" method="post">';
                                $contenu.= '<input type="hidden" name="idrdv" value="'.$row->ID_RDV.'">';
                                $contenu.= '<input type="submit" value="Supprimer le créneau " name="supp_creneau" /> ';
                                $contenu.= '</form> <hr />';
                        } else {
                            $contenu.=  $dateHeure->format('H:i') . '<br/> Tâches administratives <hr />';
                        }
                    }
                }
            }
            $contenu.= '</td>';
            //passe a la journee suivante
            $date2->modify('+1 day');
            $deb = $date2->format('Y-m-d');
        }
        $contenu.= '</tr>';
        $contenu.= '</table>';
    

        
    

    
        // Formulaire pour ajouter un nouveau RDV
                $contenu.= '<h2>Nouveau RDV</h2>';
        $contenu.= '<form class="form-container" name="formu" id="form1" action="accueil_agent.php" method="post">';
        $contenu.= ' <label for="date">Date :</label>
        <input type="date" id="date" name="date" required><br>
    
        <label for="heure">Heure :</label>
        <input type="number" id="quantity" value="8" name="heure"  min="8" max="18" required><br>';
         
        $contenu.= '<p><input type="submit" value="Valider le rdv" name="rdvnewcli" /> </p> ';
        
        $contenu.= '</fieldset>';
        $contenu.= '</form>';

        
        echo $menu;
        echo $contenu;
    }

    if(isset($_POST['rdvnewcli'])){
        
$id_employe = $_SESSION['cons'];
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
                $contenu= "<h2 class='error'>Il faut prendre un crénau entre 8h et 18h.</h2>";
                $test=FALSE;
                break;
            }

            // Vérifier si la différence des heures est d'au moins une heure
            if ($hours<60 || $hours2<60) {
                $contenu= "<h2 class='error'>Le créneau est déjà pris. </h2>";
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
                    $requete="insert into rdv values ('$fin','3','$id_employe',NULL,'$date')";
                    $resultat=$connexion->query($requete);
                    $resultat->closeCursor();
                    $contenu= '<h2>Le créneau a bien été bloqué.</h2>';
                    
                    
                    }

                    $retour= '            <form class="form-container" action="accueil_agent.php" method="post">';
                    $retour.= '              <input class="bouton" type="submit" value="Retour au planning" name="newcliplan"/>';
                    $retour.= '            </form>';

                    echo $accueil;
                    echo $contenu;
                    echo $retour;
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
            $ligne1 = $resultat->fetchall();
            $contenu.="<h2>Compte(s) du client :</h2>";
            $contenu.= '<table class="form-container2">';
            $contenu.= '<tr><th>Nom du compte</th> <th>Solde</th> <th>Montant de decouvert</th></tr>';
            $contenu.= '<tr>';
            foreach ($ligne1 as $donnee) {
                $contenu .= '<tr><th>' . $donnee->NOMCOMPTE . '</th> <th>' . $donnee->SOLDE . '€</th> <th>' . $donnee->MONTANTDECOUVERT . '€</th></tr>';
            }
            $contenu.= '</tr></table>';

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
            $contenu.= "<form class='form-container2'method='post' action='accueil_agent.php'>";
            $contenu.= "<input type='hidden' name='num_client' value='" . $idClient . "'>";
            $contenu.= "<p>Nom du conseiller : " . $rowByID['NOM_CONSEILLER'] . "</p>";
            $contenu.= "<p>Nom : <input type='text' name='nom' value='" . $rowByID['NOM'] . "'></p>";
            $contenu.= "<p>Prénom : <input type='text' name='prenom' value='" . $rowByID['PRENOM'] . "'></p>";
            $contenu.= "<p>Adresse : <input type='text' name='adresse' value='" . $rowByID['ADRESSE'] . "'></p>";
            $contenu.= "<p>Mail : <input type='text' name='mail' value='" . $rowByID['MAIL'] . "'></p>";
            $contenu.= "<p>Situation : <input type='text' name='situation' value='" . $rowByID['SITUATION'] . "'></p>";
            $contenu.= "<p>Date de naissance : <input type='date' name='datenaissance' value='" . $rowByID['DATENAISSANCE'] . "'></p>";
            $contenu.= "<p>Profession : <input type='text' name='profession' value='" . $rowByID['PROFESSION'] . "'></p>";
            $contenu.= "<input class='bouton' type='submit' value='Enregistrer les modifications' name='modification'>";
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
            
           
            $contenu= "<h2>Profil mis à jour avec succès.</h2>";
    
        



        

            echo $menu;
            echo $contenu;
        }

        

        if (isset($_POST['prendre_rdv'])) {
            $contenu='<p><h2>Visualiser le planning du conseiller</h2></p>
            <form class="form-container" action="accueil_agent.php" method="post">
            <p><strong> Semaine </strong>:
            <input type="date" name="datedeb" required/></p>
            <p><input type="submit" value="Afficher planning du conseiller" name="afficher_planning" /></p>
            </form>';

            echo $menu;
            echo $contenu;

        }

        if (isset($_POST['afficher_planning'])) {
            
               


                if (isset($_POST['datedeb'])){
                    $idClient = $_SESSION['id_client'];
                    $_SESSION['date']=$_POST['datedeb'];
                    $date = $_SESSION['date'];
                }
                else{
                    $idClient = $_SESSION['id_client'];
                    $date = $_SESSION['date'];
    
                }
                
                $contenu='<p><h2>Visualiser le planning du conseiller</h2></p>
                <form class="form-container" action="accueil_agent.php" method="post">
            <p><strong> Semaine </strong>:
            <input type="date" name="datedeb" value="' . date('Y-m-d') . '" required/></p>
            <p><input type="submit" value="Afficher planning du conseiller" name="afficher_planning" /></p>
            </form>';
           
           
            $date2 = new DateTime($date); // Utilisez la date spécifiée dans $date pour déterminer la semaine
           
            $jour_semaine = $date2->format('N');
            $date2->modify("-" . ($jour_semaine - 1) . " days"); // Début de la semaine
            $deb = $date2->format('Y-m-d');

            $requete = "select * from client join employe ON client.ID_EMPLOYE=employe.ID_EMPLOYE where client.NUMCLIENT='$idClient'";
            $resultat = $connexion->query($requete);
            $resultat->setFetchMode(PDO::FETCH_OBJ);
            $ligne1 = $resultat->fetch();

            $contenu.= '<table class="form-container3">';
            $contenu.= '<tr><th colspan="7">Planning de '. $ligne1->NOM_EMPLOYE .'</th></tr>';
            $contenu.= '<tr>';
            for ($i = 1; $i <= 7; $i++) {
                

                
                //place chaque rdv dans ca case
                $contenu.= '<td>'.$deb. '</br> <hr />';

                $requete = "SELECT DISTINCT ID_RDV, DATE_RDV, NUMCLIENT, ID_MOTIF FROM rdv NATURAL JOIN employe WHERE DATE_RDV = :dateHeureString AND employe.ID_EMPLOYE = :id_conseiller ORDER BY DATE_RDV";
                $stmt = $connexion->prepare($requete);
                $idConseiller = $ligne1->ID_EMPLOYE;
                $stmt->bindParam(':id_conseiller', $idConseiller);
                
                for ($j = 8; $j <= 18; $j++) {
                    $heure = str_pad($j, 2, "0", STR_PAD_LEFT); // Formatage de l'heure
                    $dateHeureString = $deb . ' ' . $heure . ':00:00';
                    $dateHeure = new DateTime($dateHeureString); // Création d'un objet DateTime
                
                    // Liaison de la variable :dateHeureString à la requête préparée
                    $dateHeureString = $dateHeure->format('Y-m-d H:i:s');
                    $stmt->bindParam(':dateHeureString', $dateHeureString);
                                    
                    // Exécution de la requête
                    $stmt->execute();
                    $donnees = $stmt->fetchAll(PDO::FETCH_OBJ);
                
                    if (empty($donnees)) {
                        $contenu .= "$heure:00<br><br><br><hr/>";
                    } else {
                        foreach ($donnees as $row) {
                            if (isset($row->ID_MOTIF)) {
                                
                                // Ajout de la requête pour récupérer le nom du motif
                                    $requeteMotif = "SELECT NOM_MOTIF FROM MOTIF WHERE ID_MOTIF='$row->ID_MOTIF'";
                                    $resultatMotif = $connexion->query($requeteMotif);
                                    $rowMotif = $resultatMotif->fetch(PDO::FETCH_OBJ);

                                    if (isset($row->NUMCLIENT)) {
                                        $requeteClient = "SELECT DISTINCT prenom FROM client WHERE NUMCLIENT='$row->NUMCLIENT'";
                                        $resultatClient = $connexion->query($requeteClient);
                                        $rowClient = $resultatClient->fetch(PDO::FETCH_OBJ);
                                        
                                        $contenu .= $dateHeure->format('H:i') . '<br/> Client : ' . $rowClient->prenom . '<br/> Motif : ' . $rowMotif->NOM_MOTIF;
                                        }else{
                                            $contenu .= $dateHeure->format('H:i') . '<br/> Client : nouveau client';
                                        }
                                    //bouton de synsthese
                                    $contenu.= '<form name="formu1" id="form1" action="accueil_agent.php" method="post">';
                                    $contenu.= '<input type="hidden" name="idrdv" value="'.$row->ID_RDV.'">';
                                    $contenu.= '<input type="submit" value="Supprimer le créneau " name="supp_creneau" /> ';
                                    $contenu.= '</form> <hr />';
                            } else {
                                $contenu.=  $dateHeure->format('H:i') . '<br/> Tâches administratives <hr />';
                            }
                        }
                    }
                }
                $contenu.= '</td>';
                //passe a la journee suivante
                $date2->modify('+1 day');
                $deb = $date2->format('Y-m-d');
            }
            $contenu.= '</tr>';
            $contenu.= '</table>';
        

            
        

        
            // Formulaire pour ajouter un nouveau RDV
            $contenu.= '<h2 class="form-container">Nouveau RDV</h2>';
            $contenu.= '<form class="form-container" name="formu" id="form1" action="accueil_agent.php" method="post">';
            $contenu.= ' <label for="date">Date :</label>
            <input type="date" id="date" name="date" required>
        
            <label for="heure">Heure :</label>
            <input type="number" id="quantity" value="8" name="heure"  min="8" max="18" required>';
            
            
            $requete = "SELECT * FROM motif";
            $resultat = $connexion->query($requete);
            $resultat->setFetchMode(PDO::FETCH_OBJ);
            $donnees = $resultat->fetchAll();

            $contenu.= '<label for="motif">Choisissez un motif :</label>';
            $contenu.= '<select id="motif" name="motif">';
            foreach ($donnees as $donnee) {
                $contenu.= '<option value="'. $donnee->ID_MOTIF .'">' . $donnee->NOM_MOTIF . '</option>';
            }
            $contenu.= '</select>';
            
            $contenu.= '<input type="hidden" name="numcli" value="'.$idClient.'">';

            
            $contenu.= '<p><input type="submit" value="Valider le rdv" name="enregistrement_rdv" /> </p> ';
            
            $contenu.= '</fieldset>';
            $contenu.= '</form>';

            
            echo $menu;
            echo $contenu;
        }


        if (isset($_POST['supp_creneau'])) {
            $id_rdv = $_POST["idrdv"];
            $requete="DELETE FROM `rdv` WHERE id_rdv='$id_rdv'";
            $resultat=$connexion->query($requete);
            $resultat->closeCursor();
            $contenu='<h2>Le créneau a bien était supprimé.</h2>';

            $retour= '            <form action="accueil_agent.php" method="post">';
            $retour.= '              <input type="submit" value="Retour au planning" name="afficher_planning"/>';
            $retour.= '            </form>';

            echo $menu;
            echo $contenu;
            echo $retour;

        }
    
    
            
            
            //donner du nouveau rdv
            if (isset($_POST['enregistrement_rdv'])) {
                $idClient = $_SESSION['id_client'];
                    $motif = $_POST['motif'];
                    $date1 = $_POST['date']; // Récupération de la valeur du champ 'date'
                    $heure1 = $_POST['heure'];
                    

                    

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
                        $hours = $interval->h + ($interval->days * 24);

                        $interval2 = $date2->diff($date1);
                        $hours2 =  $interval2->h + ($interval2->days * 24);

                        // Vérifier si l'heure du rendez-vous est entre 8h et 18h
                        if ($date1->format('H') < 8 || $date1->format('H') >= 18) {
                            $contenu= "Il faut prendre un rendez-vous entre 8h et 18h.";
                            $test=FALSE;
                            break;
                        }

                        // Vérifier si la différence des heures est d'au moins une heure
                        if ($hours<1 || $hours2<1) {
                            $contenu= "L'horaire est déjà pris. <br>";
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
                        $requete = "SELECT * FROM client WHERE NUMCLIENT='$idClient'";
                        $resultat = $connexion->query($requete);
                        $resultat->setFetchMode(PDO::FETCH_OBJ);
                        $ligne = $resultat->fetch();
                        $requete="insert into rdv values ('$fin','$motif','$ligne->ID_EMPLOYE','$idClient','$date')";
                        $resultat=$connexion->query($requete);
                        $resultat->closeCursor();
                        
                        //piece necessaire
                        $requete = "SELECT LITSE_PIECES FROM motif WHERE ID_MOTIF=$motif";
                        $resultat = $connexion->query($requete);
                        $resultat->setFetchMode(PDO::FETCH_OBJ);
                        $ligne = $resultat->fetch();
                        $contenu= 'Pièces nécessaires : '.$ligne->LITSE_PIECES;


                        }

                        
            $retour= '            <form action="accueil_agent.php" method="post">';
            $retour.= '              <input type="submit" value="Retour au planning" name="afficher_planning"/>';
            $retour.= '            </form>';


                        echo $menu;
                        echo $contenu;
                        echo $retour;      
                
                            
                    
                    
                  
            }


        if (isset($_POST['liste_operation'])){
            $idClient = $_SESSION['id_client'];
            $requete = "SELECT * FROM operation NATURAL JOIN compteclient WHERE NUMCLIENT=$idClient ";
            $resultat = $connexion->query($requete);
            $resultat->setFetchMode(PDO::FETCH_OBJ);
            $ligne1 = $resultat->fetchall();

            $contenu="<h2>Operation(s) du client :</h2>";
            $contenu.= '<table class="form-container">';
            $contenu.= '<tr><th>Nom du compte</th> <th>Montant</th> <th>Type de l\'operation</th></tr>';
            $contenu.= '<tr>';
            foreach ($ligne1 as $donnee) {
                $contenu .= '<tr><th>' . $donnee->NOMCOMPTE . '</th> <th>' . $donnee->MONTANT . '</th> <th>' . $donnee->TYPEOP . '</th></tr>';
            }
            $contenu.= '</tr></table>';

            echo $menu;
            echo $contenu;
            
        }

        if (isset($_POST['liste_rdv'])){
            $idClient = $_SESSION['id_client'];
            $requete = "SELECT * FROM `rdv` NATURAL JOIN motif WHERE NUMCLIENT=$idClient ";
            $resultat = $connexion->query($requete);
            $resultat->setFetchMode(PDO::FETCH_OBJ);
            $ligne1 = $resultat->fetchall();

            $contenu="<h2>Operation(s) du client :</h2>";
            $contenu.= '<table class="form-container">';
            $contenu.= '<tr><th>Date</th> <th>Motif</th> <th>Liste des pieces</th></tr>';
            $contenu.= '<tr>';
            foreach ($ligne1 as $donnee) {
                $contenu .= '<tr><th>' . $donnee->DATE_RDV . '</th> <th>' . $donnee->NOM_MOTIF . '</th> <th>' . $donnee->LITSE_PIECES . '</th></tr>';
            }
            $contenu.= '</tr></table>';

            echo $menu;
            echo $contenu;
            
        }

       


        
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
                $contenu .= "<form class='form-container2'> <ul>";
        
                foreach ($donnees as $donnee) {
                    $contenu .= '<li>ID Client : ' . $donnee['NUMCLIENT'] . '     ,   Nom : ' . $donnee['NOM'] . '          ,   Prénom : ' . $donnee['PRENOM'] . '      ,   Adresse : ' . $donnee['ADRESSE'] . '</li>';
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
            echo $accueil_nom;
            echo $contenu;
            echo $accueil_new;
        }

        if (isset ($_POST['operation'])){
            $idClient=$_SESSION['id_client'];
           
            $requete = "select DISTINCT nomcompte from compteclient where NUMCLIENT='$idClient'";
            $resultat = $connexion->query($requete);
            $resultat->setFetchMode(PDO::FETCH_OBJ);
            $ligne1 = $resultat->fetchall();
            if ($ligne1 != null){                
                $contenu='<h2> Effectuer une transaction  </h2><form class="form-container2" method="post" action="accueil_agent.php">';
                $contenu.= 'Veuillez choisir un compte  ';
                $contenu.= '<select id="motif" name="motif">';
                foreach($ligne1 as $ligne){
                $contenu.= '<option value="'.$ligne->nomcompte.'" >'.$ligne->nomcompte.'</option>';                        
                }
                $contenu.= '</select>';
                $contenu.= '<p><input class="bouton" type="submit" value="Valider le compte" name="comptecli" /> </p> ';              
                $contenu.='</form>';
            }
            else{
                $contenu='Ce client ne possède pas de compte';
            }
            echo $menu;
            echo $contenu;
        }

        if (isset ($_POST['comptecli'])){
            $idClient=$_SESSION['id_client'];
            $motif=$_POST['motif'];

            $contenu=' <h2> Effectuer une transaction  </h2><form class="form-container2" method="post" action="accueil_agent.php">';
            $contenu.= '<label for="choix">Choisissez un motif :</label>';
            $contenu.= '<select id="choix" name="choix">';
            $contenu.= '<option value="1">depot</option>';
            $contenu.= '<option value="2">retrait</option>';
            $contenu.= '</select>';

            $contenu.= '<br><label for="somme">Choisissez une somme :</label>';
            $contenu.='<input type="entier"  name="somme">';
            $contenu.='<p><input class="bouton" type="submit" value="Valider l\'opération" name="enregistrement_operation"></p>';
            $contenu.='<input type="hidden" value="'.$motif.'" name="motif2">';
            $contenu.='</form>';
            
            echo $menu;
            echo $contenu;
            
            
        }

        if (isset ($_POST['enregistrement_operation'])){
            $idClient=$_SESSION['id_client'];
            $motif=$_POST['motif2'];
            $somme=$_POST['somme'];
            $choix=$_POST['choix'];
            $requete='select solde,montantdecouvert from compteclient where numclient="'.$idClient.'" and nomcompte="'.$motif.'"';
            $resultat=$connexion->query($requete);
            $resultat->setFetchMode(PDO::FETCH_OBJ);
            $inform=$resultat->fetch();
            $operation=($inform->solde)-$somme;
            $res=($inform->solde)+$somme;

            //pas de auto_increment donc recuperer le id_rdv a la main
            $requete = "SELECT NUMOP FROM operation ORDER BY NUMOP DESC LIMIT 1";
            $resultat = $connexion->query($requete);
            $resultat->setFetchMode(PDO::FETCH_OBJ);
            $op = $resultat->fetch();
            $fin=$op->NUMOP +1;

            
            if ($choix == 1){
                $requete='update compteclient set solde=solde + '.$somme.' where numclient="'.$idClient.'" and nomcompte="'.$motif.'"';
                $resultat=$connexion->query($requete);
                $resultat->closeCursor();
                $contenu='<h2>Dépôt effectué votre solde est de '.$res.'</h2>';
                
                $requete="insert into operation values ('$fin','$idClient','$motif','$somme','depot')";
                $resultat=$connexion->query($requete);
                $resultat->closeCursor();

               

            }
            if ($choix == 2){
                if (($operation>=($inform->montantdecouvert))){
                        $requete='update compteclient set solde=solde - '.$somme.' where numclient="'.$idClient.'" and nomcompte="'.$motif.'"';
                        $resultat=$connexion->query($requete);
                        $resultat->closeCursor();
                        $contenu='<h2>Retrait effectué votre solde est de '.$operation.'</h2>';

                        $requete="insert into operation values ('$fin','$idClient','$motif','$somme','retrait')";
                        $resultat=$connexion->query($requete);
                        $resultat->closeCursor();
        
                }
                else{
                    $contenu= '<h2>Votre somme dépasse le montant découvert de votre compte, vous ne pouvez que retirer "'.$inform->montantdecouvert - $inform->solde.'"</h2>';
                }
           
                
        }
        echo $menu;
        echo $contenu;

    }



        ?>
        
        </body>
        <footer>
        <form class="deconnexion" method="post" action="accueil_agent.php">
           <input class="deco" type="submit" value="Déconnexion" name="deconnexion">
        </form>

        </footer>
        </html>