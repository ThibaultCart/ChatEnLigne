<?php
session_start();
require_once "connexion.php";

function inscription($email, $pseudo, $mdp, $ladate)
{
    $mailDejautiliser = GetEmail($email);
    $pseudodejautiliser = GetPseudo($pseudo);
    $dataOk = true;

    //on check si l'utilisateur n'est pas deja existant
    if ($mailDejautiliser != null) {
        echo '<script>alert("Votre adresse mail est deja utilisé");</script>';
        $dataOk = false;
    }
    if ($mailDejautiliser != null) {
        echo '<script>alert("Votre Pseudo est deja utilisé");</script>';
        $dataOk = false;
    }




}


function GetEmail($email)
{
    $sql = "SELECT `idUser`, `Pseudo`, `Email`
    FROM `user`
    WHERE `Email` = :email";

    $request = connect()->prepare($sql);
    $request->bindParam(":email", $email, PDO::PARAM_STR);
    $request->execute();

    return $request->fetch(PDO::FETCH_ASSOC);
}

function GetPseudo($pseudo)
{
    $sql = "SELECT `idUser`, `Pseudo`, `Email`
    FROM `user`
    WHERE `Pseudo` = :pseudo";

    $request = connect()->prepare($sql);
    $request->bindParam(":pseudo", $pseudo, PDO::PARAM_STR);
    $request->execute();

    return $request->fetch(PDO::FETCH_ASSOC);
}

// Ajouter un utilisateur
function AddUser($nomFamille, $prenom, $email, $age, $genre, $mdp, $salt){
    $sql = "INSERT INTO `Tbl_user`(`Nm_Last`, `Nm_First`, `Txt_age`, `Txt_Email`, `Txt_Gender`, `Txt_Pw`, `Txt_Salt`)
            VALUES(:nomFamille, :prenom, :age, :email, :genre, :mdp, :salt)";

    $request = connect()->prepare($sql);
    $request->bindParam(":nomFamille", $nomFamille, PDO::PARAM_STR);
    $request->bindParam(":prenom", $prenom, PDO::PARAM_STR);
    $request->bindParam(":age", $age, PDO::PARAM_STR);
    $request->bindParam(":email", $email, PDO::PARAM_STR);
    $request->bindParam(":genre", $genre, PDO::PARAM_STR);
    $request->bindParam(":mdp", $mdp, PDO::PARAM_STR);
    $request->bindParam(":salt", $salt, PDO::PARAM_STR);
    $request->execute();

    $result = $request->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}


?>