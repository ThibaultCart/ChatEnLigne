
<?php



// <editor-fold defaultstate="collapsed" desc="INSCRIPTION">
function inscription($email, $pseudo, $mdp)
{

    $erreur = null;
    $mailDejautiliser = GetAccountByEmail($email);
    $pseudodejautiliser = GetAccountByUsername($pseudo);
    $dataOk = true;

    //on check si l'utilisateur n'est pas deja inscrit avec se mail et/ou se pseudo
    if ($mailDejautiliser != null) {
        //donne a la variable erreur l'erreur
        $erreur = "Votre adresse mail est deja utilisé";
        $dataOk = false;
    }
    if ($pseudodejautiliser != null) {
        //donne a la variable erreur l'erreur
        $erreur = "Votre Pseudo est deja utilisé";
        $dataOk = false;
    }

    if ($dataOk == true) {
        //si les enregistrements ne sont pas des doublons

        //on crypte le mot de passe 
        $mdphash = Encrypt($mdp);
        // on appele la fonction qui ajoute les user dans la table
        AddUser($email, $pseudo, $mdphash);
    }
    //si une erreur a été detecter on la return si pas d'erreur on return null
    if ($erreur != null) {
        return $erreur;
    } else {
        return null;
    }
}


// Crypter le mot de passe
function Encrypt($mdp)
{
    $retour = password_hash($mdp, PASSWORD_DEFAULT);
    echo $retour;
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
    $ismailValide = GetAccountByEmail($email);
    //check si un compte est lié a cet email

    if ($ismailValide != null) {
        $connexionPossible = true;
    }
    //si le mail correspond et que le mdp n est pas vide on commence la procedure de connexion
    if ($connexionPossible == true) {
        // on recupere toutes le données de la base orrespondant a notre email
        $allinfo = GetInfoAll($email);
        var_dump($allinfo);
        $mdphash = $allinfo["Password"];
        //on ajoute le sel et on hash le mots de passe saisie
        $ispswmatch = password_verify($mdpConnexion, $mdphash);
        //on compare les deux mots de passe
        if ($ispswmatch == true) {
            // si ils sont identique on mets certaines valeur dans une variable de session et on redirige vers la page chat.php
            $_SESSION["username"] = $allinfo["username"];
            $_SESSION["Email"] = $email;
            $_SESSION["idUser"] = $allinfo["idUser"];

            header("location:chat.php");
        } else {
            // sinon on mets une alert comme quoi le mots de passe et le mail ne corresponde a aucun compte
            echo '<script>alert("Votre adresse mail et le mot de passe de correspondent pas");</script>';
        }
    }
}

?>