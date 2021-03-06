<?php

// Renvoie la liste des billets du blog
function getBillets() {
    $bdd = getBdd();
    $billets = $bdd->query('select TIC_ID as id, TIC_DATE as date,'
            . ' TIC_LIB as titre, TIC_DESC as contenu, ET_LIB as etlib from T_TICKET'
			. ' join ETAT on ETAT.ET_ID=T_TICKET.ET_ID');
    return $billets;
}

// Renvoie les informations sur un billet
function getBillet($idBillet) {
    $bdd = getBdd();
    $billet = $bdd->prepare('select TIC_ID as id, TIC_DATE as date,'
            . ' TIC_LIB as titre, TIC_DESC as contenu, ET_LIB as etlib from T_TICKET'
			. ' join ETAT ON ETAT.ET_ID=T_TICKET.ET_ID'
            . ' where TIC_ID=?');
    $billet->execute(array($idBillet));
    if ($billet->rowCount() == 1)
        return $billet->fetch();  // Accès à la première ligne de résultat
    else
        throw new Exception("Aucun billet ne correspond à l'identifiant '$idBillet'");
}

// Renvoie la liste des commentaires associés à un billet
function getCommentaires($idBillet) {
    $bdd = getBdd();
    $commentaires = $bdd->prepare('select COM_ID as id, COM_DATE as date,'
            . ' COM_AUTEUR as auteur, COM_DEV as contenu from T_COM'
            . ' where TIC_ID=?');
    $commentaires->execute(array($idBillet));
    return $commentaires;
}

// Effectue la connexion à la BDD
// Instancie et renvoie l'objet PDO associé
function getBdd() {
    $bdd = new PDO('mysql:host=localhost;dbname=monticketing;charset=utf8', 'root',
            'password', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    return $bdd;
}