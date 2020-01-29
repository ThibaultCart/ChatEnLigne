<?php
session_start();
require_once "connexion.php";

function inscription($email,$pseudo,$mdp,$ladate){
$mailDejautiliser=GetEmail($email);
$pseudodejautiliser=GetPseudo($pseudo);
$dataOk=true;
if ($mailDejautiliser!=null){
    echo '<script>alert("Votre adresse mail est deja utilisé");</script>';
    $dataOk=false;
}



}





function GetEmail($email){
    $sql = "SELECT `idUser`, `Pseudo`, `Email`
    FROM `user`
    WHERE `Email` = :email";

    $request = connect()->prepare($sql);
    $request->bindParam(":email", $email, PDO::PARAM_STR);
    $request->execute();

    return $request->fetch(PDO::FETCH_ASSOC);
}

function GetPseudo($email){
    $sql = "SELECT `idUser`, `Pseudo`, `Email`
    FROM `user`
    WHERE `Email` = :email";

    $request = connect()->prepare($sql);
    $request->bindParam(":email", $email, PDO::PARAM_STR);
    $request->execute();

    return $request->fetch(PDO::FETCH_ASSOC);
}

?>