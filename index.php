<?php
require_once "requete.php";
?>

<?php


// si le form de connexion est validé
if (isset($_POST["submitLogin"])) {
    // recupere les données envoyer par le form
    $email = filter_input(INPUT_POST, 'umail', FILTER_SANITIZE_EMAIL);
    $mdpConnexion = filter_input(INPUT_POST, 'pswConnexion', FILTER_SANITIZE_STRING);
    if (is_null($email) || is_null($mdpConnexion)) {
        echo '<script>alert("Merci de remplire les champs");</script>';
    } else {
        connexion($email, $mdpConnexion);


    }
}

// si le form d'inscription est validé

if (isset($_POST["submitInscription"])) {
    // recupere les données envoyer par le form
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $date = filter_input(INPUT_POST, 'dateNaissance', FILTER_SANITIZE_STRING);
    $pseudo = filter_input(INPUT_POST, 'uname', FILTER_SANITIZE_STRING);
    $mdp1 = filter_input(INPUT_POST, 'psw', FILTER_SANITIZE_STRING);
    $mdp2 = filter_input(INPUT_POST, 'ConfPsw', FILTER_SANITIZE_STRING);
    $valid = false;
    //Check si les mdp sont identique et pas null
    if ($mdp1 != $mdp2 && $mdp1 != "" && $mdp2 != "") {
        echo '<script>alert("Les Mots de passe ne correspondent pas");</script>';

        $valid = false;
    } else {
        $valid = true;
    }
// check si le format du mail est correct (si l'user trifatouille dans le code html)
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

    } else {
        $valid = false;
        //affiche en message d'alert l'erreur

        echo '<script>alert("Merci de saisir un email dans un format valide");</script>';
    }
//si un des champs saisie est vide
    if (is_null($email) || is_null($date) || is_null($mdp2) || is_null($pseudo) || is_null($mdp1)) {
        //affiche en message d'alert l'erreur

        echo '<script>alert("un ou plusieurs champs sont vide");</script>';
        $valid = false;
    } else {
        $valid = true;
    }

//efface toutes les valeurs présentes dans le post
    if (count($_POST) > 0) {
        foreach ($_POST as $k => $v) {
            unset($_POST[$k]);
        }
    }

// si les données saisie sont conforme on commence l'inscription
    if ($valid == true) {
        $erreur = inscription($email, $pseudo, $mdp1, $date);

        if ($erreur != null) {
            //affiche en message d'alert l'erreur
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
    <button onclick="document.getElementById('id02').style.display = 'block'" style="width:500px;">Inscription</button>
</fieldset>
<!---- Form Connexion-->
<div id="id01" class="modal">

    <form class="modal-content animate" action="index.php" method="post">
        <div class="imgcontainer">
            <span onclick="document.getElementById('id01').style.display = 'none'" class="close" title="Close Modal">&times;</span>
            <img src="Images/img_avatar2.png" alt="Avatar" class="avatar">
        </div>

        <div class="container">
            <label for="umail"><b>Votre Email</b></label>
            <input type="email" placeholder="Votre Email" name="umail" required>

            <label for="psw"><b>Mot de passe</b></label>
            <input type="password" placeholder="Votre Mots de passe" name="pswConnexion" required>

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

<!---- Form Inscription-->
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
