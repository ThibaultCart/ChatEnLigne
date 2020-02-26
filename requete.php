<?php
session_start();
require_once "connexion.php";

// <editor-fold defaultstate="collapsed" desc="INSCRIPTION">
function inscription($email, $pseudo, $mdp, $ladate)
{

    $erreur=null;
    $mailDejautiliser = GetEmail($email);
    $pseudodejautiliser = GetPseudo($pseudo);
    $dataOk = true;
//changement du format de la date
    $ladate2 = strtotime($ladate);

    $ladate = date("Y-m-d", $ladate2);


    //on check si l'utilisateur n'est pas deja inscrit avec se mail et/ou se pseudo
    if ($mailDejautiliser != null) {
        //donne a la variable erreur l'erreur
       $erreur="Votre adresse mail est deja utilisé";
        $dataOk = false;
    }
    if ($pseudodejautiliser != null) {
        //donne a la variable erreur l'erreur
        $erreur="Votre Pseudo est deja utilisé";
        $dataOk = false;
    }

    if ($dataOk == true) {
        //si les enregistrements ne sont pas des doublons
        //on crypte le sel en sha1
        $sel = GenerateRandomString();
        $sel = sha1($sel);
        //on crypte le mot de passe et lui ajoutant le sel crypter (toujour en sha 1)
        $mdphash = Encrypt($mdp, $sel);
        // on appele la fonction qui ajoute les user dans la table
        AddUser($email, $pseudo, $mdphash, $sel, $ladate);

    }
    //si une erreur a été detecter on la return si pas d'erreur on return null
    if($erreur!=null){
        return $erreur;
    }else{
        return null;
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
function GenerateRandomString($length = 10)
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
    $Concmdpsalt = $mdp . $salt;
    $retour = sha1($Concmdpsalt);

    return $retour;
}


//fonction appelé si le form et remplis
function connexion($email, $mdpConnexion)
{


    $connexionPossible = false;
// verifie que le mail et le mdp sois remplis
    if ($email != null || $mdpConnexion != null || $mdpConnexion != "" || $email != "") {
        $connexionPossible = false;
    }
    $ismailValide = GetEmail($email);
    //check si un compte est lié a cet email

    if ($ismailValide != null) {
        $connexionPossible = true;

    }
    //si le mail correspond et que le mdp n est pas vide on commence la procedure de connexion
    if ($connexionPossible == true) {
// on recupere toutes le données de la base orrespondant a notre email
        $allinfo = GetInfoAll($email);
        var_dump($allinfo);
        $salt = $allinfo["salt"];
        $mdphash = $allinfo["Password"];
        //on ajoute le sel et on hash le mots de passe saisie
        $concMdpHash = $mdpConnexion . $salt;
        $mdpSaisie = sha1($concMdpHash);
        //on compare les deux mots de passe
        if ($mdpSaisie == $mdphash) {
            // si ils sont identique on mets certaines valeur dans une variable de session et on redirige vers la page chat.php
            $_SESSION["Pseudo"] = $allinfo["Pseudo"];
            $_SESSION["mail"] = $email;
            $_SESSION["idUser"] = $allinfo["idUser"];

            header("location:chat.php");
        } else {
            // sinon on mets une alert comme quoi le mots de passe et le mail ne corresponde a aucun compte
            echo '<script>alert("Votre adresse mail et le mot de passe de correspondent pas");</script>';
        }

    }


}

function GetInfoAll($email)
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