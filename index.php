<?php
require_once "requete.php";
?>

<?php

// Variable

if (isset($_POST["submitLogin"])) {

}

if (isset($_POST["submitInscription"])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $date = filter_input(INPUT_POST, 'dateNaissance', FILTER_SANITIZE_STRING);
    $pseudo = filter_input(INPUT_POST, 'uname', FILTER_SANITIZE_STRING);
    $mdp1 = filter_input(INPUT_POST, 'psw', FILTER_SANITIZE_STRING);
    $mdp2 = filter_input(INPUT_POST, 'ConfPsw', FILTER_SANITIZE_STRING);
    $valid = false;
    if ($mdp1 != $mdp2&&$mdp1!=""&&$mdp2!="") {
        echo '<script>alert("Les Mots de passe ne correspondent pas");</script>';

        $valid = false;
    } else {
        $valid = true;
    }
    if (is_null($email) || is_null($date)|| is_null($mdp2) || is_null($pseudo) || is_null($mdp1)) {

        echo '<script>alert("un ou plusieurs champs sont vide");</script>';
        $valid = false;
    } else {
        $valid = true;
    }


    // si les données saisie sont conforme on commence l'inscription
    if ($valid == true) {
        inscription($email,$pseudo,$mdp1,$date);
    } else {

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
    <button onclick="document.getElementById('id02').style.display = 'block'" style="width:500px;">Inscription</button>
</fieldset>
<div id="id01" class="modal">

    <form class="modal-content animate" action="index.php" method="post">
        <div class="imgcontainer">
            <span onclick="document.getElementById('id01').style.display = 'none'" class="close" title="Close Modal">&times;</span>
            <img src="Images/img_avatar2.png" alt="Avatar" class="avatar">
        </div>

        <div class="container">
            <label for="uname"><b>Utilisateur</b></label>
            <input type="text" placeholder="Enter Username" name="uname" required>

            <label for="psw"><b>Mot de passe</b></label>
            <input type="password" placeholder="Enter Password" name="psw" required>

            <button type="submit" name="submitLogin">Login</button>
            <label>
                <input type="checkbox" checked="checked" name="remember"> Remember me
            </label>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="document.getElementById('id01').style.display = 'none'" class="cancelbtn">
                Cancel
            </button>
            <span class="psw">Forgot <a href="#">password?</a></span>
        </div>
    </form>
</div>
<div id="id02" class="modal">

    <form class="modal-content animate" action="index.php" method="post">
        <div class="imgcontainer">
            <span onclick="document.getElementById('id02').style.display = 'none'" class="close" title="Close Modal">&times;</span>
            <img src="Images/img_avatar2.png" alt="Avatar" class="avatar">
        </div>

        <div class="container">
            <label for="uname"><b>Utilisateur</b></label>
            <input type="text" placeholder="Entrer Username" name="uname" required>
            <label for="email"><b>Email</b></label>
            <input type="email" placeholder="Entrer Email" name="email" required>
            <label for="dateNaissance"><b>Date de naissance</b></label>
            <input type="date" placeholder="Date de naissance" name="dateNaissance" required>
            <label for="psw"><b>Mot de passe</b></label>
            <input type="password" placeholder="Entrer Password" name="psw" required>
            <label for="confPsw"><b>Confirmer mot de passe</b></label>
            <input type="password" placeholder="Confirmer Password" name="ConfPsw" required>

            <button type="submit" name="submitInscription">S'inscrire</button>

        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="document.getElementById('id02').style.display = 'none'" class="cancelbtn">
                Cancel
            </button>
            <span class="psw">Forgot <a href="#">password?</a></span>
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
