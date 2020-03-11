<?php
require_once "requete.php";
?>

<?php

/*
 * Author(s)    :   Thibault, Douglas, Mayara
 * File         :   index.php
 * Project      :   ChatUp
 * Description  :   Index file | View | Process form validation
 * Last modif.  :   10.03.2020 by Douglas
 */

// Check : login form was requested
if (isset($_POST["submitLogin"])) {
    
    // recupere les données envoyer par le form
    $emailLogin = filter_input(INPUT_POST, 'emailLogin', FILTER_SANITIZE_EMAIL);
    $passwordLogin = filter_input(INPUT_POST, 'passwordLogin', FILTER_SANITIZE_STRING);
    
    if (is_null($emailLogin) || is_null($passwordLogin)) {
        echo '<script>alert("Merci de remplire les champs");</script>';
    } else {
        connexion($emailLogin, $passwordLogin);
    }
}

// Check : registration form was requested
if (isset($_POST["submitRegisterUser"])) {


    $emailLogin = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $passwordRegistration = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $passwordConfirmation = filter_input(INPUT_POST, 'passwordConfirmation', FILTER_SANITIZE_STRING);
    $valid = false; // is used for validation throughout the process of registration

    //Check : Identical passwords
    if ($passwordRegistration != $passwordConfirmation && $passwordRegistration != "" && $passwordConfirmation != "") {
        echo '<script>alert("The password and password confirmation are not identical.");</script>';

        $valid = false;
    } else {
        $valid = true;
    }

    // Check : Email is an email
    if (filter_var($emailLogin, FILTER_VALIDATE_EMAIL)) {

    } else {
        $valid = false;
        echo '<script>alert("Please enter a valid email.");</script>';
    }

    // Check : Empty fields
    if (is_null($emailLogin) || is_null($passwordConfirmation) || is_null($username) || is_null($passwordRegistration)) {

        echo '<script>alert("One or multiple fields are empty.");</script>';
        $valid = false;
    } else {
        $valid = true;
    }

    // Security : Erase all data stored in POST
    if (count($_POST) > 0) {
        foreach ($_POST as $k => $v) {
            unset($_POST[$k]);
        }
    }

    // Validation
    if ($valid == true) {

        // Last check for errors
        $erreur = RegisterUser($emailLogin, $username, $passwordRegistration);
        if ($erreur != null) {
            echo '<script>alert("' . $erreur . '");</script>';
        }
    }

}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>

        <fieldset>
            <legend><h2>ChatUp</h2></legend>
            <button onclick="document.getElementById('id01').style.display = 'block'" style="width:500px;">Connexion</button>
            <br>
            <button onclick="document.getElementById('id02').style.display = 'block'" style="width:500px;">RegisterUser</button>
        </fieldset>
        <!---- Connection Form-->
        <div id="id01" class="modal">
            <form class="modal-content animate" action="index.php" method="post">
                <div class="imgcontainer">
                    <span onclick="document.getElementById('id01').style.display = 'none'" class="close" title="Close Modal">&times;</span>
                    <img src="Images/img_avatar2.png" alt="Avatar" class="avatar">
                </div>

                <div class="container">
                    <label for="emailLogin"><b>Email</b></label>
                    <input type="email" placeholder="Enter email" name="emailLogin" required>
                    <label for="password"><b>Password</b></label>
                    <input type="password" placeholder="Enter password" name="passwordLogin" required>

                    <button type="submit" name="submitLogin">Connection</button>
                </div>

            </form>
        </div>

        <!---- Registration Form -->
        <div id="id02" class="modal">

            <form class="modal-content animate" action="index.php" method="post">
                <div class="imgcontainer">
                    <span onclick="document.getElementById('id02').style.display = 'none'" class="close" title="Close Modal">&times;</span>
                    <img src="Images/img_avatar2.png" alt="Avatar" class="avatar">
                </div>
                <div class="container">
                    <label for="username"><b>Username</b></label>
                    <input type="text" placeholder="Enter username" name="username" required>
                    <label for="email"><b>Email</b></label>
                    <input type="email" placeholder="Enter email" name="email" required>
                    <label for="password"><b>Password</b></label>
                    <input type="password" placeholder="Enter password" name="password" required>
                    <label for="passwordConfirmation"><b>Password confirmation</b></label>
                    <input type="password" placeholder="Confirm Password" name="passwordConfirmation" required>
                    <button type="submit" name="submitRegisterUser">Register</button>
                </div>
            </form>
        </div>

        <script>
            // Get the modal
            var modal = document.getElementById('id01');
            var modal2 = document.getElementById('id02');

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
                if (event.target == modal2) {
                    modal2.style.display = "none";
                }
            }
        </script>
    </body>
</html>
