<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Accueil</title>
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


        // Bouton accueil
        $accueil= '<header>';
        //$accueil.= '<h2>Accueil</h2>';
        //$accueil.= '      <li class="menu-item">';
        $accueil.= '       <form method="post" action="accueil_directeur.php">';
        $accueil.= '          <input class="accueil" type="submit" value="Accueil" name="accueil">';
        $accueil.= '        </form>';
        //$accueil.= '      </li>';
        $accueil.= '</header>';

//recuperer nom dir
$id_employe = $_SESSION['id_employe'];
$requete = "SELECT NOM_EMPLOYE FROM employe where ID_EMPLOYE='$id_employe'";
$resultat = $connexion->query($requete);
$ligne = $resultat->fetch(PDO::FETCH_OBJ);

$accueil1= '<h3>Bienvenue, directeur '.$ligne->NOM_EMPLOYE.'</h3>';

$directeur= '<form action="accueil_directeur.php" method="post">';
$directeur.= '   <input type="submit" value="Employé.s" name="rechercher_directeur"/>';
$directeur.= '</form>';

//MENU
$menu= '<header>';
$menu.= '    <nav> ';
$menu.= '    <ul class="menu-list">';


$menu.= '      <li class="menu-item"> Employés ';
$menu.= '        <ul class="submenu">';
$menu.= '          <li>';
$menu.= '            <form action="accueil_directeur.php" method="post">';
$menu.= '              <input type="submit" value="Les employés" name="employes"/>';
$menu.= '            </form>';
$menu.= '          </li>';
$menu.= '          <li>';
$menu.= '            <form action="accueil_directeur.php" method="post">';
$menu.= '              <input type="submit" value="Ajouter un employé" name="ajouter_employe"/>';
$menu.= '            </form>';
$menu.= '          </li>';
$menu.= '        </ul>';
$menu.= '      </li>';

$menu.= '      <li class="menu-item"> Contrats ';
$menu.= '        <ul class="submenu">';
$menu.= '           <li>';
$menu.= '            <form action="accueil_directeur.php" method="post">';
$menu.= '              <input type="submit" value="Supprimer les contrats" name="modifier_contrat"/>';
$menu.= '            </form>';
$menu.= '          </li>';
$menu.= '           <li>';
$menu.= '            <form action="accueil_directeur.php" method="post">';
$menu.= '              <input type="submit" value="Ajouter un contrat" name="ajouter_contrat"/>';
$menu.= '            </form>';
$menu.= '          </li>';
$menu.= '           <li>';
$menu.= '            <form action="accueil_directeur.php" method="post">';
$menu.= '              <input type="submit" value="Liste des contrats" name="liste_contrat"/>';
$menu.= '            </form>';
$menu.= '          </li>';
$menu.= '        </ul>';
$menu.= '      </li>';

$menu.= '      <li class="menu-item"> Comptes ';
$menu.= '        <ul class="submenu">';
$menu.= '           <li>';
$menu.= '            <form action="accueil_directeur.php" method="post">';
$menu.= '              <input type="submit" value="Supprimer les comptes" name="modifier_compte"/>';
$menu.= '            </form>';
$menu.= '          </li>';
$menu.= '           <li>';
$menu.= '            <form action="accueil_directeur.php" method="post">';
$menu.= '              <input type="submit" value="Ajouter un compte" name="ajouter_compte"/>';
$menu.= '            </form>';
$menu.= '          </li>';
$menu.= '           <li>';
$menu.= '            <form action="accueil_directeur.php" method="post">';
$menu.= '              <input type="submit" value="Liste des comptes" name="liste_compte"/>';
$menu.= '            </form>';
$menu.= '          </li>';
$menu.= '        </ul>';
$menu.= '      </li>';

$menu.= '      <li class="menu-item"> Rendez-vous ';
$menu.= '        <ul class="submenu">';
$menu.= '           <li>';
$menu.= '            <form action="accueil_directeur.php" method="post">';
$menu.= '              <input type="submit" value="Modifier les motifs" name="modifier_motif"/>';
$menu.= '            </form>';
$menu.= '          </li>';
$menu.= '           <li>';
$menu.= '            <form action="accueil_directeur.php" method="post">';
$menu.= '              <input type="submit" value="Ajouter un motif" name="ajouter_motif"/>';
$menu.= '            </form>';
$menu.= '          </li>';
$menu.= '           <li>';
$menu.= '            <form action="accueil_directeur.php" method="post">';
$menu.= '              <input type="submit" value="Liste des motifs" name="liste_motif"/>';
$menu.= '            </form>';
$menu.= '          </li>';
$menu.= '        </ul>';
$menu.= '      </li>';


$menu.= '      <li class="menu-item"> Voir les statistiques';
$menu.= '        <ul class="submenu">';
$menu.= '          <li>';
$menu.= '            <form action="accueil_directeur.php" method="post">';
$menu.= '              <input type="submit" value="nombre de contrats souscris " name="nbcontrat"/>';
$menu.= '              <input type="submit" value="nombre de rdv pris" name="nbrdv"/>';
$menu.= '              <input type="submit" value="compte clients de la banque" name="nbclient"/>';
$menu.= '            </form>';
$menu.= '          </li>';
$menu.= '        </ul>';
$menu.= '      </li>';

$menu.= '    </ul>';
$menu.= '   </nav>';
$menu.= '</header>'; 



if ((!isset($_SESSION['first_load']))) {
    
    $_SESSION['first_load'] = false; // Marquer la page comme déjà chargée
    echo $accueil;
    echo $menu;
    echo $accueil1;
    
}

if(isset($_POST['deconnexion'])){
    session_unset(); // Supprime toutes les variables de session
    session_destroy(); // Détruit la session actuelle
    header("Location: connexion.php"); // Redirige vers la page de connexion
    exit; // Arrête l'exécution du script après la redirection
}

if (isset($_POST['accueil'])) {
    echo $accueil;
    echo $menu;
    echo $accueil1;
}


//MODIFIER LOGIN ET MDP EMPLOYE
if (isset($_POST['employes'])) {
    // Afficher la liste des employés avec un formulaire pour sélectionner un employé
    $requete = "SELECT * FROM employe";
    $resultat = $connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    
    $contenu= '<h2><label for="selectEmploye">Modifier login/mdp employés</label></h2>';
    $contenu.= '<form class="form-container2" action="accueil_directeur.php" method="post">Sélectionner un employé :';
    $contenu .= '<select id="selectEmploye" name="selectedEmploye">';
    
    while ($employe = $resultat->fetch()) {
        $contenu .= '<option value="' . $employe->ID_EMPLOYE . '">' . $employe->NOM_EMPLOYE . ' - ' . $employe->STATUT . '</option>';
    }

    $contenu .= '</select>';
    $contenu .= ' <input class="bouton" type="submit" value="Afficher les détails" name="afficherDetailsEmploye" />';
    $contenu .= '</form>';

    echo $accueil;
    echo $menu;
    echo $contenu;
}

if (isset($_POST['afficherDetailsEmploye'])) {
    // Récupérer les détails de l'employé sélectionné
    $selectedEmployeId = $_POST['selectedEmploye'];
    $requeteDetails = "SELECT * FROM employe WHERE ID_EMPLOYE = :idEmploye";
    $stmtDetails = $connexion->prepare($requeteDetails);
    $stmtDetails->bindParam(':idEmploye', $selectedEmployeId);
    $stmtDetails->execute();
    $detailsEmploye = $stmtDetails->fetch(PDO::FETCH_OBJ);

    // Afficher les détails
    $contenuDetails = '<h2>Détails de l\'employé</h2>';
    $contenuDetails .= '<div class="form-container2"><p>Nom : ' . $detailsEmploye->NOM_EMPLOYE . '</p>';
    $contenuDetails .= '<p>Statut : ' . $detailsEmploye->STATUT . '</p>';
    $contenuDetails .= '<p>Login : ' . $detailsEmploye->LOGIN . '</p>';

    // Formulaire pour modifier le login
    $contenuDetails .= '<form action="accueil_directeur.php" method="post">';
    $contenuDetails .= '<input type="hidden" name="idEmploye" value="' . $detailsEmploye->ID_EMPLOYE . '" />';
    $contenuDetails .= '<label for="nouveauLogin">Nouveau login :</label>';
    $contenuDetails .= '<input type="text" id="nouveauLogin" name="nouveauLogin" required />';
    $contenuDetails .= '<input class="bouton" type="submit" value="Modifier le login" name="modifierLogin" />';
    $contenuDetails.= '</form>';
    
    // Formulaire pour modifier le mot de passe
    $contenuDetails .= '<form action="accueil_directeur.php" method="post">';
    $contenuDetails .= '<input type="hidden" name="idEmploye" value="' . $detailsEmploye->ID_EMPLOYE . '" />';
    $contenuDetails .= '<label for="nouveauMdp">Nouveau mot de passe :</label>';
    $contenuDetails .= '<input type="password" id="nouveauMdp" name="nouveauMdp" required />';
    $contenuDetails .= '<input class="bouton" type="submit" value="Modifier le mot de passe" name="modifierMdp" />';
    $contenuDetails .= '</form>';
    $contenuDetails .= '</div>';

    echo $accueil;
    echo $menu;
    echo $contenuDetails;
}

if (isset($_POST['modifierMdp']) && isset($_POST['idEmploye']) && isset($_POST['nouveauMdp'])) {
    // Modifier le mot de passe de l'employé
    $idEmploye = $_POST['idEmploye'];
    $nouveauMdp = $_POST['nouveauMdp'];

    $requeteUpdateMdp = "UPDATE employe SET MOTDEPASSE = :nouveauMdp WHERE ID_EMPLOYE = :idEmploye";
    $stmtUpdateMdp = $connexion->prepare($requeteUpdateMdp);
    $stmtUpdateMdp->bindParam(':nouveauMdp', $nouveauMdp);
    $stmtUpdateMdp->bindParam(':idEmploye', $idEmploye);
    $stmtUpdateMdp->execute();

    echo $accueil;
    echo $menu;
    echo "Le mot de passe a été modifié avec succès.";

    // Afficher les détails de l'employé mis à jour
    afficherDetailsEmploye($connexion, $idEmploye);
}

if (isset($_POST['modifierLogin']) && isset($_POST['idEmploye']) && isset($_POST['nouveauLogin'])) {
    // Modifier le login de l'employé
    $idEmploye = $_POST['idEmploye'];
    $nouveauLogin = $_POST['nouveauLogin'];

    $requeteUpdateLogin = "UPDATE employe SET LOGIN = :nouveauLogin WHERE ID_EMPLOYE = :idEmploye";
    $stmtUpdateLogin = $connexion->prepare($requeteUpdateLogin);
    $stmtUpdateLogin->bindParam(':nouveauLogin', $nouveauLogin);
    $stmtUpdateLogin->bindParam(':idEmploye', $idEmploye);
    $stmtUpdateLogin->execute();

    echo $accueil;
    echo $menu;
    echo "<h2>Le login a été modifié avec succès.</h2>";

    // Afficher les détails de l'employé mis à jour
    afficherDetailsEmploye($connexion, $idEmploye);
}


// Fonction pour RE-afficher les détails de l'employé après avoir fais une modification
function afficherDetailsEmploye($connexion, $idEmploye) {
    $requeteDetails = "SELECT * FROM employe WHERE ID_EMPLOYE = :idEmploye";
    $stmtDetails = $connexion->prepare($requeteDetails);
    $stmtDetails->bindParam(':idEmploye', $idEmploye);
    $stmtDetails->execute();
    $detailsEmploye = $stmtDetails->fetch(PDO::FETCH_OBJ);

    // Afficher les détails
    $contenuDetails = '<h2>Détails de l\'employé</h2>';
    $contenuDetails .= '<div class="form-container2"><p>Nom : ' . $detailsEmploye->NOM_EMPLOYE . '</p>';
    $contenuDetails .= '<p>Statut : ' . $detailsEmploye->STATUT . '</p>';
    $contenuDetails .= '<p>Login : ' . $detailsEmploye->LOGIN . '</p>';

    // Formulaire pour modifier le login
    $contenuDetails .= '<form action="accueil_directeur.php" method="post">';
    $contenuDetails .= '<input type="hidden" name="idEmploye" value="' . $detailsEmploye->ID_EMPLOYE . '" />';
    $contenuDetails .= '<label for="nouveauLogin">Nouveau login :</label>';
    $contenuDetails .= '<input type="text" id="nouveauLogin" name="nouveauLogin" required />';
    $contenuDetails .= '<input class="bouton" type="submit" value="Modifier le login" name="modifierLogin" />';
    $contenuDetails.= '</form>';
    
    // Formulaire pour modifier le mot de passe
    $contenuDetails .= '<form action="accueil_directeur.php" method="post">';
    $contenuDetails .= '<input type="hidden" name="idEmploye" value="' . $detailsEmploye->ID_EMPLOYE . '" />';
    $contenuDetails .= '<label for="nouveauMdp">Nouveau mot de passe :</label>';
    $contenuDetails .= '<input type="password" id="nouveauMdp" name="nouveauMdp" required />';
    $contenuDetails .= '<input class="bouton" type="submit" value="Modifier le mot de passe" name="modifierMdp" />';
    $contenuDetails .= '</form>';
    $contenuDetails .= '</div>';

    echo $contenuDetails;
}


//AJOUTER UN EMPLOYE
if (isset($_POST['ajouter_employe'])){
    echo $accueil;
    echo $menu;

    // Afficher le formulaire pour ajouter un nouvel employé
    echo '<h2>Ajouter un nouvel employé</h2>';
    echo '<div class="form-container2"><form action="accueil_directeur.php" method="post">';
    echo '<p class="cote"><label for="nom">Nom :</label>';
    echo '<input type="text" id="nom" name="nom" required /></p>';
    echo '<p class="cote"><label for="statut">Statut :</label>';
    echo '<select id="statut" name="statut" required ></p>';
    echo '  <p class="cote"> <option value="conseiller">Conseiller</option>';
    echo '   <option value="agent">Agent</option>';
    echo '</select><br />';
    echo '<p class="cote"><label for="login">Login :</label>';
    echo '<input type="text" id="login" name="login" required /></p>';
    echo '<p class="cote"><label for="mdp">Mot de passe :</label>';
    echo '<input type="password" id="mdp" name="mdp" required /></p>';
    echo '<input class="bouton" type="submit" value="Ajouter" name="ajouter_employe_submit" />';
    echo '</form></div>';

    // Afficher les employés existants
    $requeteEmployes = "SELECT * FROM employe";
    $resultatEmployes = $connexion->query($requeteEmployes);
    $resultatEmployes->setFetchMode(PDO::FETCH_OBJ);

    echo '<h2>Liste des employés</h2>';
    echo '<p><ul class="form-container2">';
    while ($employe = $resultatEmployes->fetch()) {
        echo '<li>' . $employe->NOM_EMPLOYE . ' - ' . $employe->STATUT . '</li>';
    }
    echo '</ul></p>';
}

if (isset($_POST['ajouter_employe_submit'])) {
    // Traiter le formulaire pour ajouter un nouvel employé
    $nom = $_POST['nom'];
    $statut = $_POST['statut'];
    $login = $_POST['login'];
    $mdp = $_POST['mdp'];

    //pas de auto_increment donc recuperer le id_employe a la main
    $requete = "SELECT ID_EMPLOYE FROM employe ORDER BY ID_EMPLOYE DESC LIMIT 1";
    $resultat = $connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $num = $resultat->fetch();
    $fin=$num->ID_EMPLOYE + 1;

    // Utilisez des paramètres liés pour éviter les problèmes de sécurité
    $requete = "INSERT INTO employe VALUES (:idEmploye, :login, :statut, :nom, :mdp)";
    
    $stmt = $connexion->prepare($requete);
    $stmt->bindParam(':idEmploye', $fin);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':statut', $statut);
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':mdp', $mdp);

    if ($stmt->execute()) {
        echo $accueil;
        echo $menu;
        echo '<h2>L\'employé a été ajouté avec succès.</h2>';
    } else {
        echo $accueil;
        echo $menu;
        echo '<h2 class="error">Erreur lors de l\'ajout de l\'employé.</h2>';
    }
}



if (isset ($_POST['liste_contrat'])){
    $requete='select nom_contrat from contrat';
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $inform=$resultat->fetchall();

    if ($inform==null){
        $contenu="<h2> . Aucun contrat n'existe dans votre banque</h2>";
    }
    else{
        $contenu='<h2>Liste des contrats : </h2><div class="form-container2">';
        foreach($inform as $ligne){
            
            $contenu.= $ligne->nom_contrat.'</br>';
            
            
          }
        $contenu.='</div>';  

    }
    echo $accueil;
    echo $menu;
    echo $contenu;


}

if (isset ($_POST['ajouter_contrat'])){

    
    $requete='select nom_contrat from contrat';
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $inform=$resultat->fetchall();

    $contenu='<h2>Ajouter un nouveau contrat à la banque </h2> <form method="post">';
    $contenu.='<div class="form-container2"><p>Nom du contrat : <input type="text" name="nom"></p>';
    $contenu.='<p><input class="bouton" type="submit" value="Ajouter le contrat" name="envoyer"/></p>';
    $contenu.='</form></div>';
    if ($inform==null){
        $contenu.=" <h2> Aucun contrat n'existe dans votre banque.</h2>";
    }
    else{
        $contenu.='<h2>Liste des contrat : </h2>';
        $contenu.='<div class="form-container2">';
        foreach($inform as $ligne){
            
            $contenu.= $ligne->nom_contrat.'</br>';
            
          }
         $contenu.='</div>'; 

    }

    echo $accueil;
    echo $menu;
    echo $contenu;

}

if (isset($_POST['envoyer'])){

    $nom=$_POST['nom'];
    
    if (!empty($nom)){
      
      $requete="insert into contrat Values('$nom')";
      $resultat=$connexion->query($requete);
      $resultat->closeCursor();

      $requete = "SELECT ID_MOTIF FROM motif ORDER BY ID_MOTIF DESC LIMIT 1";
      $resultat = $connexion->query($requete);
      $resultat->setFetchMode(PDO::FETCH_OBJ);
      $num = $resultat->fetch();
      $fin=$num->ID_MOTIF + 1;
    
      $requete="INSERT INTO `motif`(`ID_MOTIF`, `NOM_MOTIF`, `LITSE_PIECES`) VALUES ($fin,'Ouverture du contrat $nom','Pas determiner')";
      $resultat=$connexion->query($requete);
      $resultat->closeCursor();

      $fin2=$fin + 1;
      $requete="INSERT INTO `motif`(`ID_MOTIF`, `NOM_MOTIF`, `LITSE_PIECES`) VALUES ($fin2,'Fermeture du contrat $nom','Pas determiner')";
      $resultat=$connexion->query($requete);
      $resultat->closeCursor();
    

   
    $contenu= '<h2>Le contract a bien été ajouté.';
    }
    else{
        $contenu= '<h2>Le contract n\'a pas été enregistré.</h2>';
    }
    echo $accueil;
    echo $menu;
    echo $contenu;
  }



if (isset ($_POST['modifier_contrat'])){
                    
                    
    $requete='select nom_contrat from contrat';
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $inform=$resultat->fetchall();
    
    
    $contenu3='<form method="post"><h2>Sélectionner les contrats de la banque à supprimer</h2>';

    
    if ($inform==null){

        $contenu3.="<h2> Aucun contrat n'existe dans votre banque.</h2>";
    }
    
    else{
        
        $contenu3.='<div class="form-container2"<p>';
        foreach($inform as $ligne){
            
          $check='<input type ="radio" name="contrats_supp" value="'.$ligne->nom_contrat.'"/>';
          $contenu3.='<label>'.$check.'&nbsp;'.$ligne->nom_contrat.'&nbsp;</label></p>';
          
        }
        $contenu3.='<label class="pas_de_style">&nbsp;</label><p><input class="bouton" type="submit" value="Supprimer contrat" name ="supprimer"/></p>';
        $contenu3.='</form></div>';

    }

    echo $accueil;
    echo $menu;
    echo $contenu3;
}

if (isset ($_POST['supprimer']) && isset($_POST['contrats_supp'])){

    $id=$_POST['contrats_supp'];

    $requete = "SELECT COUNT(*) AS occurences FROM contatclient WHERE nom_contrat = '$id'";
    $resultat = $connexion->query($requete);
    $donnees = $resultat->fetch(PDO::FETCH_ASSOC);

    

    $nb_occurrences = $donnees['occurences'];
        
    if ($nb_occurrences == 0){
          $requete="Delete from contrat where nom_contrat='$id'";
          $resultat=$connexion->query($requete);
          $resultat->closeCursor();
          $contenu= '<h2>Le contrat a bien été supprimé.<h2>';
        }else{
            $contenu= '<h2>Le contrat ne peut pas etre supprimé car il y a '.$nb_occurrences.' contrat client avec se nom.</h2>';
        }
      
    echo $accueil;
      echo $menu;
      echo $contenu;
      
}






if (isset ($_POST['liste_compte'])){
    $requete='select nomcompte from compte';
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $inform=$resultat->fetchall();

    if ($inform==null){
        $contenu="<h2>Aucun compte n'existe dans votre banque.</h2>";
    }
    else{
        $contenu='<h2>Liste des comptes : </h2>';
        $contenu.='<div class="form-container2"><p>';
        foreach($inform as $ligne){
            
            $contenu.= $ligne->nomcompte.'</br>';
            
            
          }
          $contenu.='</p></div>';


    }
    echo $accueil;
    echo $menu;
    echo $contenu;


}

if (isset ($_POST['ajouter_compte'])){

    
    $requete='select nomcompte from compte';
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $inform=$resultat->fetchall();

    $contenu='<h2>Ajouter un compte à la banque</h2> <form class="form-container2" method="post">';
    $contenu.='<p><label>Nouveau compte :</label><input type="text" name="nom"></p>';
    $contenu.='<p><input class="bouton" type="submit" value="Ajouter le compte" name="envoye_compte"/></p>';
    $contenu.='</form>';
    if ($inform==null){
        $contenu.=" <h2>Aucun compte n'existe dans votre banque.</h2>";
    }
    else{
        $contenu.='<h2>Liste des comptes : </h2>';
        $contenu.='<div class="form-container2"><p>';

        foreach($inform as $ligne){
            
            $contenu.= $ligne->nomcompte.'</br>';
            
            
          }
          $contenu.='</p></div>';


    }

    echo $accueil;
    echo $menu;
    echo $contenu;

}

if (isset($_POST['envoye_compte'])){

    $nom=$_POST['nom'];
    
    if (!empty($nom)){
      
      $requete="insert into compte Values('$nom')";
      $resultat=$connexion->query($requete);
      $resultat->closeCursor();

      $requete = "SELECT ID_MOTIF FROM motif ORDER BY ID_MOTIF DESC LIMIT 1";
      $resultat = $connexion->query($requete);
      $resultat->setFetchMode(PDO::FETCH_OBJ);
      $num = $resultat->fetch();
      $fin=$num->ID_MOTIF + 1;
    
      $requete="INSERT INTO `motif`(`ID_MOTIF`, `NOM_MOTIF`, `LITSE_PIECES`) VALUES ($fin,'Ouverture du compte $nom','Pas determiner')";
      $resultat=$connexion->query($requete);
      $resultat->closeCursor();

      $fin2=$fin + 1;
      $requete="INSERT INTO `motif`(`ID_MOTIF`, `NOM_MOTIF`, `LITSE_PIECES`) VALUES ($fin2,'Fermeture du compte $nom','Pas determiner')";
      $resultat=$connexion->query($requete);
      $resultat->closeCursor();

   
    $contenu= '<h2>Le compte a bien été enregistré.</h2>';
    }
    else{
        $contenu= '<h2>Le compte n\'a pas été enregistré.</h2>';
    }
    echo $accueil;
    echo $menu;
    echo $contenu;
  }



if (isset ($_POST['modifier_compte'])){
                    
                    
    $requete='select nomcompte from compte';
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $inform=$resultat->fetchall();
    
    
    
    $contenu3='<h2>Sélectionner les comptes de la banque à supprimer</h2><form class="form-container2" method="post">';

    
    if ($inform==null){

        $contenu3.="<h2> Aucun compte n'existe dans votre banque.</h2>";
    }
    
    else{
        

        


        foreach($inform as $ligne){
            
          $check='<input type ="radio" name="comptes_supp" value="'.$ligne->nomcompte.'"/>';
          $contenu3.='<p><label>'.$check.'&nbsp;'.$ligne->nomcompte.'&nbsp;</label></p>';
          
        }
        $contenu3.='<label class="pas_de_style">&nbsp;</label><p><input class="bouton" type="submit" value="supprimer compte" name ="supprimer_compte"/></p>';
        $contenu3.='</form>';

    
    }

    echo $accueil;
    echo $menu;
    echo $contenu3;
}

if (isset ($_POST['supprimer_compte']) && isset($_POST['comptes_supp'])){

    $new=$_POST['comptes_supp'];

    $requete = "SELECT COUNT(*) AS occurences FROM compteclient WHERE nomcompte = '$new'";
    $resultat = $connexion->query($requete);
    $donnees = $resultat->fetch(PDO::FETCH_ASSOC);

    $nb_occurrences = $donnees['occurences'];
    
        
    if ($nb_occurrences == 0){
          $requete="Delete from compte where nomcompte='$new'";
          $resultat=$connexion->query($requete);
          $resultat->closeCursor();
          $contenu='<h2>Le compte a bien été supprimé.</h2>';
        }else{
            $contenu= '<h2>Le compte ne peut pas etre supprimé car il y a '.$nb_occurrences.' compte client avec ce nom.</h2>';
        }
      echo $accueil;
      echo $menu;
      echo $contenu;
      
}





if (isset ($_POST['liste_motif'])){
    $requete='select NOM_MOTIF,LITSE_PIECES from motif';
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $inform=$resultat->fetchall();

    if ($inform==null){
        $contenu="<h2>Aucun motif n'existe dans votre banque.</h2>";
    }
    else{
        $contenu='<h2>Liste des motifs : </br></h2>';
        $contenu.='<div class="form-container2"><p>';

        foreach($inform as $ligne){
           
            $contenu.='Nom du motif : '. $ligne->NOM_MOTIF.' </br>    Pièces à fournir :'.$ligne->LITSE_PIECES.' </br></br>';
            
            
          }
          $contenu.='</div></p>';


    }
    echo $accueil;
    echo $menu;
    echo $contenu;


}

if (isset ($_POST['ajouter_motif'])){

    
    $requete='select NOM_MOTIF from motif';
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $inform=$resultat->fetchall();

    $contenu='<h2>Ajouter un motif</h2> <form class="form-container2" method="post">';
    $contenu.='<p><label>Nouveau motif :</label><input type="text" name="nom"></p>';
    $contenu.='<p><label>Pieces néssecaires :</label><input type="text" name="pieces"></p>';
    $contenu.='<p><input class="bouton" type="submit" value="Ajouter le motif" name="envoyer_motif"/></p>';
    $contenu.='</form>';
    if ($inform==null){
        $contenu.=" <h2> Aucun motif n'existe dans votre banque.</h2>";
    }
    else{

        $contenu.='<h2>Liste des motifs : </h2>';
        $contenu.='<div class="form-container2"><p>';

        foreach($inform as $ligne){
            
            $contenu.= $ligne->NOM_MOTIF.'</br>';
            
            
          }
          $contenu.='<div></p>';


    }

    echo $accueil;
    echo $menu;
    echo $contenu;

}

if (isset($_POST['envoyer_motif'])){

    $nom=$_POST['nom'];
    $pieces=$_POST['pieces'];

    $requete = "SELECT ID_MOTIF FROM motif ORDER BY ID_MOTIF DESC LIMIT 1";
    $resultat = $connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $num = $resultat->fetch();
    $fin=$num->ID_MOTIF + 1;
    
    if ((!empty($nom)) && (!empty($pieces))){
      
      $requete="insert into motif Values('$fin','$nom','$pieces')";
      $resultat=$connexion->query($requete);
      $resultat->closeCursor();
    

   
    $contenu= '<h2>Le motif a bien été enregistré.</h2>';
    }
    else{
        $contenu= '<h2>Le motif n\'a pas été enregistré.</h2>';
    }
    echo $accueil;
    echo $menu;
    echo $contenu;
  }



if (isset ($_POST['modifier_motif'])){
                    
                    
    $requete='select NOM_MOTIF,ID_MOTIF from motif';
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $inform=$resultat->fetchall();
    
    $contenu2='<h2>Sélectionner les motifs de la banque à modifier</h2><form class="form-container2" method="post">';
    $contenu3='<h2>Sélectionner les motifs de la banque à supprimer</h2><form class="form-container2" method="post">';

    
    if ($inform==null){

        $contenu3.="<h2>Aucun motif n'existe dans votre banque.</h2>";
    }
    
    else{
        
        foreach($inform as $ligne){
            if ($ligne->NOM_MOTIF != 'autre'){
          $check='<input type ="radio" name="motifs_modif" value="'.$ligne->ID_MOTIF.'"/>';
          $contenu2.='<p><label>'.$check.'&nbsp;'.$ligne->NOM_MOTIF.'&nbsp;</label></p>';
            }
        }
        $contenu2.='<label class="pas_de_style">&nbsp;</label><p><input class="bouton" type="submit" value="Modifier le motif" name ="modif_motif"/></p>';
        $contenu2.='</fieldset></form>';
        


        foreach($inform as $ligne){
            if ($ligne->NOM_MOTIF != 'autre'){
          $check='<input type ="radio" name="motifs_supp" value="'.$ligne->ID_MOTIF.'"/>';
          $contenu3.='<p><label>'.$check.'&nbsp;'.$ligne->NOM_MOTIF.'&nbsp;</label></p>';
            }
        }
        $contenu3.='<label class="pas_de_style">&nbsp;</label><p><input class="bouton" type="submit" value="Supprimer motif(s)" name ="supprimer_motif"/></p>';
        $contenu3.='</fieldset></form>';



       
    }

    echo $accueil;
    echo $menu;
    echo $contenu2;
    echo $contenu3;
}

if (isset ($_POST['supprimer_motif']) && isset($_POST['motifs_supp'])){
    $id = $_POST["motifs_supp"];
    
    


    $requete = "SELECT COUNT(*) AS occurences FROM rdv WHERE ID_MOTIF = '$id'";
    $resultat = $connexion->query($requete);
    $donnees = $resultat->fetch(PDO::FETCH_ASSOC);

    $nb_occurrences = $donnees['occurences'];

    if ($nb_occurrences == 0){
        $requete="Delete from motif where ID_MOTIF='$id'";
        $resultat=$connexion->query($requete);
      $resultat->closeCursor();
      $contenu= '<h2>Le motif a bien été supprimé.</h2>';
    }else{
        $contenu= '<h2>Le motif ne peut pas etre supprimé car il y a '.$nb_occurrences.' rendez-vous avec se motif.</h2>';
    }
        
          
        
      echo $accueil;
      echo $menu;
      echo $contenu;
      
      
}

if (isset($_POST['modif_motif'])){
    $valeurSelectionnee = $_POST["motifs_modif"];
    
    $requete="select LITSE_PIECES,NOM_MOTIF from motif where ID_MOTIF='$valeurSelectionnee'";
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $inform=$resultat->fetch();

    

    
    
    $contenu='<h2>Changer les pièces à fournir: </h2>';
    $contenu.='<form class="form-container2" method="post"> <h2>Le motif selectionné est : '.$inform->NOM_MOTIF.'</h2>
    <p><input type="text" name="changement" /></p>
    <input type="hidden" value='.$valeurSelectionnee.' name="ancien" /></p>
    <p><input class="bouton" type="submit" value="Enregistrer le changement" name="update_motif" /></p>
    </form>';

    $contenu.= '<p> Les pieces demandées étaient : '.$inform->LITSE_PIECES.'</p>';

    echo $accueil;
    echo $menu;
    echo $contenu;

}

if (isset($_POST['update_motif'])){
    $ancien = $_POST["ancien"];
    $changement = $_POST["changement"];

    $requete="UPDATE `motif` SET `LITSE_PIECES`='$changement' WHERE ID_MOTIF='$ancien'";
    $resultat=$connexion->query($requete);
    $resultat->closeCursor();

    echo $accueil;
    echo $menu;
    if ($resultat !== false) {
        $rowCount = $resultat->rowCount();
        
        if ($rowCount > 0) {
            echo "<h2>La mise à jour a été effectuée avec succès.</h2>";
        } else {
            echo "<h2>Aucune mise à jour effectuée.</h2>";
        }
    } else {
        echo "<h2>Échec de la mise à jour.</h2>";
    }



}






if (isset ($_POST['nbcontrat'])){
    
    $contenu='<h2>Nombre de contrats souscris</h2><form class="form-container2" method="post"><p><strong>Choisir deux dates:</strong></p>
    <p><label> date de debut :</label>
    <input type="date" name="datedeb" /></p>
    <p><label> date de fin :</label>
    <input type="date" name="datefin" /></p>
    <p><input class="bouton" type="submit" value="Voir entre les deux dates" name="afficher_deux_date" /></p>
    
    </form>';

    $requete = 'SELECT count(*) as count FROM contatclient';
    $resultat = $connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $inform = $resultat->fetch();

    if ($inform !== false && isset($inform->count)) {
        if ($inform->count == 0) {
            $contenu .= "<h2>Aucun contrat n'existe dans votre banque.</h2>";
        } else {
            $contenu .= '<h2>Nombre de contrat actuellement : ';
            $contenu .= $inform->count . '</br></h2>';
        }
    } else {
        $contenu .= "<h2>Une erreur s'est produite lors de la récupération des données.</h2>";
    }

    echo $accueil;
    echo $menu;
    echo $contenu;

       
}

if (isset ($_POST['afficher_deux_date'])){

$date1 = $_POST['datedeb'];
$date2 = $_POST['datefin'];

if ($date2<$date1){
    $contenu= "<h2>Veuillez choisir une date de debut qui soit anterieur à celle de fin</h2>";

}
else{
$requete = "SELECT count(*) as count FROM contatclient WHERE DATEOUVERTURECONTRAT >= '$date1' AND DATEOUVERTURECONTRAT <= '$date2'";
$resultat = $connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$inform = $resultat->fetchAll();

$resultat = $connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $inform = $resultat->fetch();
    $contenu= "<h2>Nombre de contract : </h2>";
    if ($inform !== false && isset($inform->count)) {
        if ($inform->count == 0) {
            $contenu .= "<h2>Aucun contrat n'existe dans votre banque</h2>";
        } else {
            $contenu .= '<p>Nombre de contrat entre le '.$date1.' et le '.$date2.' est de  ';
            $contenu .= $inform->count . '</br></p>';
        }
    } else {
        $contenu .= "<h2 class='error'>Une erreur s'est produite lors de la récupération des données.</h2>";
    }
}
    echo $accueil;
    echo $menu;
    echo $contenu;

}





if (isset ($_POST['nbrdv'])){
    
    $contenu='<h2>Nombre de rendez-vous pris par les agents d\'accueil</h2><form class="form-container2" method="post"><p><strong>Choisir deux date:</strong></p>
    <p><label> date de debut :</label>
    <input type="date" name="datedeb" /></p>
    <p><label> date de fin :</label>
    <input type="date" name="datefin" /></p>
    <p><input class="bouton" type="submit" value="Voir entre les deux date" name="afficher_deux_date_rdv" /></p>
    
    </form>';

    $requete = 'SELECT count(*) as count FROM rdv';
    $resultat = $connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $inform = $resultat->fetch();

    if ($inform !== false && isset($inform->count)) {
        if ($inform->count == 0) {
            $contenu .= "<h2>Aucun rendez-vous n'existe dans votre banque</h2>";
        } else {
            $contenu .= '<p>Nombre de rendez-vous actuellement : ';
            $contenu .= $inform->count . '</br></p>';
        }
    } else {
        $contenu .= "<h2>Une erreur s'est produite lors de la récupération des données.</h2>";
    }

    echo $accueil;
    echo $menu;
    echo $contenu;

       
}

if (isset ($_POST['afficher_deux_date_rdv'])){

$date1 = $_POST['datedeb'];
$date2 = $_POST['datefin'];

if ($date2<$date1){
    $contenu= "<h2>Veuillez choisir une date de debut qui soit anterieur à celle de fin</h2>";

}
else{
$requete = "SELECT count(*) as count FROM rdv WHERE DATE_RDV >= '$date1' AND DATE_RDV <= '$date2'";
$resultat = $connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$inform = $resultat->fetchAll();

$resultat = $connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $inform = $resultat->fetch();
    $contenu= "<h2>Nombre de rendez-vous : </h2>";
    if ($inform !== false && isset($inform->count)) {
        if ($inform->count == 0) {
            $contenu .= "<h2>Aucun rendez-vous n'existe dans votre banque.</h2>";
        } else {
            $contenu .= '<p>Nombre de rendez-vous entre le '.$date1.' et le '.$date2.' est de  ';
            $contenu .= $inform->count . '</br></p>';
        }
    } else {
        $contenu .= "<h2>Une erreur s'est produite lors de la récupération des données.</h2>";
    }
}
    echo $accueil;
    echo $menu;
    echo $contenu;

}






if (isset ($_POST['nbclient'])){
    
    $contenu='<h2>Total de tous les clients de la banque et total solde </h2><form class="form-container2" method="post"><p>Choisir la date:</p>
    <p><input type="date" name="datedeb" /></p>
    <p><input class="bouton" type="submit" value="Voir à cette date" name="afficher_nbclient" /></p>
    
    </form>';

    $requete = 'SELECT count(*) as count FROM client';
    $resultat = $connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $inform = $resultat->fetch();

    $requete = 'SELECT count(*) as te FROM compteclient';
    $resultat = $connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $nbcompte = $resultat->fetch();

    $requete = 'SELECT SUM(SOLDE) as somme FROM `compteclient`;';
    $resultat = $connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $solde = $resultat->fetch();

    if ($inform !== false && isset($inform->count)) {
        if ($inform->count == 0) {
            $contenu .= "<h2>Aucun client n'existe dans votre banque.</h2>";
        } else {
            $contenu .= '<p>Nombre de client actuellement : ';
            $contenu .= $inform->count . '</br>';
            $contenu .= 'Nombre de compte client actuellement : ';
            $contenu .= $nbcompte->te . '</br>';
            $contenu .= 'Le solde total de tout les compte de la banque est de : ';
            $contenu .= $solde->somme . '€ </br></p>';
        }
    } else {
        $contenu .= "<h2>Une erreur s'est produite lors de la récupération des données.</h2>";
    }

    echo $accueil;
    echo $menu;
    echo $contenu;

       
}

if (isset ($_POST['afficher_nbclient'])){

$date1 = $_POST['datedeb'];



$requete = "SELECT count(*) as count FROM compteclient WHERE DATEOUVERTURE <= '$date1'";
$resultat = $connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$inform = $resultat->fetchAll();

$resultat = $connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $inform = $resultat->fetch();
    $contenu= "<h2>Solde total des clients de la banque : </h2>";
    if ($inform !== false && isset($inform->count)) {
        if ($inform->count == 0) {
            $contenu .= "<h2>Aucun client ne sont enregistrer avant le ".$date1."</h2>";
        } else {
            $contenu .= '<p>Nombre de compte client avant le '.$date1.' est de  ';
            $contenu .= $inform->count . '</br></p>';
        }
    } else {
        $contenu .= "<h2 class='error'>Une erreur s'est produite lors de la récupération des données.</h2>";
    }

    echo $accueil;
    echo $menu;
    echo $contenu;

}



?>





        
        
        </body>
        <footer>
        <form method="post" action="accueil_directeur.php">
           <input class="deco" type="submit" value="Déconnexion" name="deconnexion">
        </form>

        </footer>
        </html>