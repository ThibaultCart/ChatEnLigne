<?php
session_start();
require_once "connexion.php";
require_once "function.php";
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
function AddUser($email, $pseudo, $mdp, $date)
{
    $sql = "INSERT INTO `user`(`Pseudo`, `Email`, `Password`,`dateNaissance`)
            VALUES(:pseudo, :email, :password,:dateNaissance);";

    $request = connect()->prepare($sql);
    $request->bindParam(":pseudo", $pseudo, PDO::PARAM_STR);
    $request->bindParam(":email", $email, PDO::PARAM_STR);
    $request->bindParam(":password", $mdp, PDO::PARAM_STR);
    $request->bindParam(":email", $email, PDO::PARAM_STR);
    $request->bindParam(":dateNaissance", $date, PDO::PARAM_STR);
    $request->execute();

    $result = $request->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

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

function GetInfoAll($email)
{
    //cherche dans la base le sel
    $sql = "SELECT `idUser`,`Pseudo`,`Password`
    FROM `user`
    WHERE `Email` = :leEmail ;";

    $request = connect()->prepare($sql);
    $request->bindParam(":leEmail", $email, PDO::PARAM_STR);
    $request->execute();

    return $request->fetch(PDO::FETCH_ASSOC); 
}
