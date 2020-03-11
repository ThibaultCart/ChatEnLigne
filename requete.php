<?php
session_start();
require_once "connexion.php";
require_once "function.php";

/**
 * Register a user.
 * Explicit : Checks if the user exists, and calls AddUser.
 * Example : RegisterUser('xyz@example.com', 'username', 'password')
 * @param $email email of user
 * @param $username Username of user 
 * @param $password Password of user
 * @return string if error present | null if no error reported
 */
function RegisterUser($email, $username, $password)
{

    $error = null;
    $mailAlreadyUsed = GetAccountByEmail($email);
    $usernameAlreadyUsed = GetAccountByUsername($username);
    $dataOk = true;

    // Check for email doublons
    if ($mailAlreadyUsed != null) {
        $error = "Another account uses this email.";
        $dataOk = false;
    }
    // Check for username doublons
    if ($usernameAlreadyUsed != null) {
        $error = "This username is not available.";
        $dataOk = false;
    }

    // No doublons found : Process of registration starts
    if ($dataOk == true) {

        $encryptedPassword = Encrypt($password);
        AddUser($email, $username, $encryptedPassword);
    }

    if ($error != null) {
        return $error;
    } else {
        return null;
    }
}


/**
 * Search if the us
 * @param $username
 * @return mixed
 */
function GetAccountByUsername($username)
{

    $sql = "SELECT `idUser`, `username`, `email`
    FROM `user`
    WHERE `username` = :username";

    $request = connect()->prepare($sql);
    $request->bindParam(":username", $username, PDO::PARAM_STR);
    $request->execute();

    return $request->fetch(PDO::FETCH_ASSOC);
}


/**
 * Add a user to the database
 * @param $email
 * @param $username
 * @param $password
 * @param $salt
 * @param $date
 * @return array
 */
function AddUser($email, $username, $password)
{
    $sql = "INSERT INTO `user`(`username`, `email`, `password`)
            VALUES(:username, :email, :password)";

    $request = connect()->prepare($sql);
    $request->bindParam(":username", $username, PDO::PARAM_STR);
    $request->bindParam(":email", $email, PDO::PARAM_STR);
    $request->bindParam(":password", $password, PDO::PARAM_STR);
    $request->execute();

    $result = $request->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

/**
 * Get all data linked to an email
 * @param $email Specified email
 * @return false if the account doesn't exist | array with data if the account exists
 */
function GetAccountByEmail($email)
{
    $sql = "SELECT `idUser`, `username`, `email`
    FROM `user`
    WHERE `email` = :email";

    $request = connect()->prepare($sql);
    $request->bindParam(":email", $email, PDO::PARAM_STR);
    $request->execute();

    return $request->fetch(PDO::FETCH_ASSOC);
}

/**
 * Check fields and connect user if no errors are found.
 * @param $email
 * @param $passwordConnexion
 */
function TheConnexion($email, $passwordConnexion)
{

    $valideConnexion = false;

    // Check empty fields
    if ($email != null || $passwordConnexion != null || $passwordConnexion != "" || $email != "") {
        $valideConnexion = false;
    }

    // Email validation
    if (GetAccountByEmail($email) != null) {
        $valideConnexion = true;
    }
    if ($valideConnexion == true) {
        $allinfo = GetInfoAll($email);


        $encryptedPassword = $allinfo["password"];

        $passwordSaisie = $passwordConnexion;
$checkpassword=password_verify($passwordSaisie,$encryptedPassword);
        if ($checkpassword==true) {

            $_SESSION["username"] = $allinfo["username"];
            $_SESSION["email"] = $email;
            $_SESSION["idUser"] = $allinfo["idUser"];

            header("location:chat.php");
           
        } else {
            
            echo '<script>alert("Votre adresse mail et le mot de passe de correspondent pas");</script>';
        }
    }
    
}

/**
 * @param $email : Contains email of an account that exists in the database.
 * @return an array containing all fields of an entry in the database.
 */
function GetInfoAll($email)
{
    // Get the user data
    $sql = "SELECT `idUser`,`username`,`password`
    FROM `user`
    WHERE `email` = :email";

    // Prepare and execute the query
    $request = connect()->prepare($sql);
    $request->bindParam(":email", $email, PDO::PARAM_STR);
    $request->execute();

    // Return all results from the query
    return $request->fetch(PDO::FETCH_ASSOC);
}
