<?php
/*
* Author(s)    :   Thibault, Douglas, Mayara
* File         :   connexion.php
* Project      :   ChatUp
* Description  :   Access MySQL Database
* Last modif.  :   02.2020 by Thibault
*/


// Connection to the Database
function connect(){
    static $myDb = null;
    $dbName = "bdchatup";
    $dbUser = "root";
    $dbPass = "";
    if ($myDb === null) {
        try {
            $myDb = new PDO(
                "mysql:host=localhost;dbname=$dbName;charset=utf8",
                $dbUser,
                $dbPass,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false)
            );
        } catch (Exception $e) {
            die("Impossible de se connecter à la base ". $e->getMessage());
        }
    }
    return $myDb;
}

?>