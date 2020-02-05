<?php
session_start();
require_once "connexion.php";

// <editor-fold defaultstate="collapsed" desc="INSCRIPTION">
function inscription($email, $pseudo, $mdp, $ladate)
{


    $mailDejautiliser = GetEmail($email);
    $pseudodejautiliser = GetPseudo($pseudo);
    $dataOk = true;
//changement du format de la date
    $ladate2 = strtotime($ladate);
    $ladate = date("Y-m-d", $ladate2);


    //on check si l'utilisateur n'est pas deja inscrit avec se mail et/ou se pseudo
    if ($mailDejautiliser != null) {
        //affiche l'erreur a l'utilisateur avec une alert
        echo '<script>alert("Votre adresse mail est deja utilisé");</script>';
        $dataOk = false;
    }
    if ($pseudodejautiliser != null) {
        //affiche l'erreur a l'utilisateur avec une alert
        echo '<script>alert("Votre Pseudo est deja utilisé");</script>';
        $dataOk = false;
    }

    if ($dataOk == true) {
        //si les enregistrements ne sont pas des doublons
        //on crypte le sel en sha1
        $sel = generateRandomString();
        $sel = sha1($sel);
        //on crypte le mot de passe et lui ajoutant le sel crypter (toujour en sha 1)
        $mdphash = Encrypt($mdp, $sel);
        AddUser($email, $pseudo, $mdphash, $sel, $ladate);

    }
    //efface toutes les valeurs présentes dans le post
    if (count($_POST) > 0) {
        foreach ($_POST as $k => $v) {
            unset($_POST[$k]);
        }
    }

}


function GetPseudo($pseudo)
{
    //cherche dans la base si le Pseudo est deja present
    $sql = "SELECT `idUser`, `Pseudo`, `Email`
    FROM `user`
    WHERE `Pseudo` = :pseudo";

    $request = connect()->prepare($sql);
    $request->bindParam(":pseudo", $pseudo, PDO::PARAM_STR);
    $request->execute();

    return $request->fetch(PDO::FETCH_ASSOC);
}

// Ajouter un utilisateur
function AddUser($email, $pseudo, $mdp, $salt, $date)
{
    $sql = "INSERT INTO `user`(`Pseudo`, `Email`, `Password`, `salt`,`datenaissance`)
            VALUES(:pseudo, :email, :password, :salt,:datenaissance)";

    $request = connect()->prepare($sql);
    $request->bindParam(":pseudo", $pseudo, PDO::PARAM_STR);
    $request->bindParam(":email", $email, PDO::PARAM_STR);
    $request->bindParam(":password", $mdp, PDO::PARAM_STR);
    $request->bindParam(":email", $email, PDO::PARAM_STR);
    $request->bindParam(":salt", $salt, PDO::PARAM_STR);
    $request->bindParam(":datenaissance", $date, PDO::PARAM_STR);
    $request->execute();

    $result = $request->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}


//Permet de genérer un sel aléatoire
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// </editor-fold>


function GetEmail($email)
{
    //cherche dans la base si le mail est deja present
    $sql = "SELECT `idUser`, `Pseudo`, `Email`
    FROM `user`
    WHERE `Email` = :email";

    $request = connect()->prepare($sql);
    $request->bindParam(":email", $email, PDO::PARAM_STR);
    $request->execute();

     return $request->fetch(PDO::FETCH_ASSOC);
}



// Crypter le mot de passe
function Encrypt($mdp, $salt)
{
    // $retour = hash("sha256", $salt . $mdp);
    $Concmdpsalt = $mdp + $salt;
    $retour = sha1($Concmdpsalt);

    return $retour;
}


//fonction appelé si le form et remplis
function connexion($email, $mdpConnexion)
{


    $connexionPossible = false;

    if ($email != null || $mdpConnexion != null || $mdpConnexion != "" || $email != "") {
        $connexionPossible = false;
    }
    $ismailValide = GetEmail($email);
    if ($ismailValide != null) {
        $connexionPossible = true;

    }
    if ($connexionPossible == true) {

        $allinfo = getallinfo($email);
        var_dump($allinfo);
        $salt = $allinfo["salt"];
        $mdphash = $allinfo["Password"];
        $concMdpHash = $mdpConnexion + $salt;
        $mdpSaisie = sha1($concMdpHash);
        if ($mdpSaisie == $mdphash) {
            $_SESSION["Pseudo"] = $allinfo["Pseudo"];
            $_SESSION["mail"] = $email;
            $_SESSION["idUser"] = $allinfo["idUser"];

            header("location:chat.php");
        } else {
            echo '<script>alert("Votre adresse mail et le mot de passe de correspondent pas");</script>';
        }

    }


}
function getallinfo($email)
{
    //cherche dans la base le sel
    $sql = "SELECT `idUser`,`Pseudo`,`Password`,`salt` 
    FROM `user`
    WHERE `Email` = :email";

    $request = connect()->prepare($sql);
    $request->bindParam(":email", $email, PDO::PARAM_STR);
    $request->execute();

    return $request->fetch(PDO::FETCH_ASSOC);
}



?>